
<?php

include "includes/db.php";

include "includes/header.php";
?>

<style>
/* All Products Page */

.all-products-page {
    padding: 70px 0;
}

.all-products-header {
    text-align: center;
    margin-bottom: 45px;
}

.all-products-label {
    margin: 0 0 10px;
    font-size: 14px;
    font-weight: bold;
    letter-spacing: 2px;
    color: #d71920;
}

.all-products-title {
    margin: 0 0 15px;
    font-size: 42px;
    font-weight: bold;
}

.all-products-description {
    max-width: 650px;
    margin: 0 auto;
    font-size: 16px;
    line-height: 1.7;
    color: #666;
}

/* Search */

.all-products-search {
    width: 100%;
    max-width: 1000px;
    margin: 0 auto 50px;
}

.all-products-search-form {
    display: flex;
    width: 100%;
    gap: 12px;
}

.all-products-search-input {
    flex: 1;
    width: 100%;
    height: 55px;
    padding: 0 20px;
    box-sizing: border-box;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: white;
    color: #222;
    font-size: 16px;
    outline: none;
}

.all-products-search-input:focus {
    border-color: #d71920;
}

.all-products-search-button {
    width: 150px;
    height: 55px;
    border: none;
    border-radius: 8px;
    background: #d71920;
    color: white;
    font-size: 15px;
    font-weight: bold;
    cursor: pointer;
}

.all-products-search-button:hover {
    background: #b71319;
}

/* Product Grid */

.all-products-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 28px;
}

/* Product Card */

.all-products-card {
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: white;
    border: 1px solid #eee;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
    transition: 0.2s ease;
}

.all-products-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

/* Product Image */

.all-products-image {
    width: 100%;
    height: 240px;
    overflow: hidden;
    background: #f7f7f7;
}

.all-products-image img {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: contain;
}

.all-products-no-image {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #aaa;
    font-size: 45px;
}

/* Product Information */

.all-products-info {
    display: flex;
    flex-direction: column;
    flex: 1;
    padding: 22px;
}

.all-products-level {
    margin-bottom: 8px;
    font-size: 12px;
    font-weight: bold;
    color: #d71920;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.all-products-name {
    margin: 0 0 10px;
    font-size: 20px;
    line-height: 1.4;
}

.all-products-description-text {
    min-height: 45px;
    margin: 0 0 20px;
    color: #777;
    font-size: 14px;
    line-height: 1.6;
}

/* Bottom */

.all-products-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    margin-top: auto;
}

.all-products-price {
    margin: 0;
    color: #d71920;
    font-size: 18px;
    white-space: nowrap;
}

.all-products-cart-form {
    margin: 0;
}

.all-products-cart-button {
    min-width: 145px;
    height: 44px;
    padding: 0 18px;
    border: none;
    border-radius: 6px;
    background: #d71920;
    color: white;
    font-size: 13px;
    font-weight: bold;
    cursor: pointer;
    white-space: nowrap;
}

.all-products-cart-button:hover {
    background: #b71319;
}

.all-products-disabled {
    background: #999;
    cursor: not-allowed;
}

/* Empty */

.all-products-empty {
    grid-column: 1 / -1;
    width: 100%;
    padding: 60px 20px;
    box-sizing: border-box;
    text-align: center;
    color: #777;
}

/* Responsive */

@media (max-width: 900px) {
    .all-products-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 650px) {
    .all-products-page {
        padding: 45px 0;
    }

    .all-products-title {
        font-size: 32px;
    }

    .all-products-search-form {
        flex-direction: column;
    }

    .all-products-search-button {
        width: 100%;
    }

    .all-products-grid {
        grid-template-columns: 1fr;
    }

    .all-products-bottom {
        flex-direction: column;
        align-items: stretch;
    }

    .all-products-cart-button {
        width: 100%;
    }
}
</style>

<?php

$search = trim($_GET['search'] ?? '');
$category_id = isset($_GET['category']) ? (int) $_GET['category'] : 0;


/* Get category name */

$category_name = '';

if ($category_id > 0) {

    $category_stmt = $conn->prepare("
        SELECT name
        FROM categories
        WHERE id = ?
        LIMIT 1
    ");

    $category_stmt->bind_param("i", $category_id);
    $category_stmt->execute();

    $category_result = $category_stmt->get_result();
    $category = $category_result->fetch_assoc();

    if ($category) {
        $category_name = $category['name'];
    }

    $category_stmt->close();
}


/* Get products */

if ($category_id > 0 && $search !== '') {

    $stmt = $conn->prepare("
        SELECT
            products.id,
            products.name,
            products.description,
            products.price,
            products.stock,
            products.image,
            categories.name AS category_name,
            edu_lvls.name AS edu_name
        FROM products
        INNER JOIN categories
            ON products.category_id = categories.id
        INNER JOIN edu_lvls
            ON categories.edu_lvls_id = edu_lvls.id
        WHERE products.category_id = ?
        AND products.name LIKE ?
        ORDER BY products.id DESC
    ");

    $search_term = "%" . $search . "%";

    $stmt->bind_param(
        "is",
        $category_id,
        $search_term
    );

    $stmt->execute();

    $products = $stmt->get_result();

} elseif ($category_id > 0) {

    $stmt = $conn->prepare("
        SELECT
            products.id,
            products.name,
            products.description,
            products.price,
            products.stock,
            products.image,
            categories.name AS category_name,
            edu_lvls.name AS edu_name
        FROM products
        INNER JOIN categories
            ON products.category_id = categories.id
        INNER JOIN edu_lvls
            ON categories.edu_lvls_id = edu_lvls.id
        WHERE products.category_id = ?
        ORDER BY products.id DESC
    ");

    $stmt->bind_param(
        "i",
        $category_id
    );

    $stmt->execute();

    $products = $stmt->get_result();

} elseif ($search !== '') {

    $stmt = $conn->prepare("
        SELECT
            products.id,
            products.name,
            products.description,
            products.price,
            products.stock,
            products.image,
            categories.name AS category_name,
            edu_lvls.name AS edu_name
        FROM products
        INNER JOIN categories
            ON products.category_id = categories.id
        INNER JOIN edu_lvls
            ON categories.edu_lvls_id = edu_lvls.id
        WHERE products.name LIKE ?
        ORDER BY products.id DESC
    ");

    $search_term = "%" . $search . "%";

    $stmt->bind_param(
        "s",
        $search_term
    );

    $stmt->execute();

    $products = $stmt->get_result();

} else {

    $products = $conn->query("
        SELECT
            products.id,
            products.name,
            products.description,
            products.price,
            products.stock,
            products.image,
            categories.name AS category_name,
            edu_lvls.name AS edu_name
        FROM products
        INNER JOIN categories
            ON products.category_id = categories.id
        INNER JOIN edu_lvls
            ON categories.edu_lvls_id = edu_lvls.id
        ORDER BY products.id DESC
    ");
}

?>

<section class="all-products-page">

    <div class="container">

        <div class="all-products-header">

            <p class="all-products-label">
                <?= $category_id > 0 ? htmlspecialchars($category_name) : 'SHOP' ?>
            </p>

            <h1 class="all-products-title">

                <?php if ($category_id > 0): ?>

                    <?= htmlspecialchars($category_name) ?>

                <?php else: ?>

                    All Products

                <?php endif; ?>

            </h1>

            <p class="all-products-description">

                <?php if ($category_id > 0): ?>

                    Browse products available in this category.

                <?php else: ?>

                    Browse all stationery and supplies available
                    for every education level.

                <?php endif; ?>

            </p>

        </div>


        <div class="all-products-search">

            <form
                method="GET"
                action="products.php"
                class="all-products-search-form"
            >

                <?php if ($category_id > 0): ?>

                    <input
                        type="hidden"
                        name="category"
                        value="<?= $category_id ?>"
                    >

                <?php endif; ?>

                <input
                    type="text"
                    name="search"
                    placeholder="Search products by name..."
                    value="<?= htmlspecialchars($search) ?>"
                    class="all-products-search-input"
                >

                <button
                    type="submit"
                    class="all-products-search-button"
                >
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Search
                </button>

            </form>

        </div>


        <div class="all-products-grid">

            <?php if ($products && $products->num_rows > 0): ?>

                <?php while ($product = $products->fetch_assoc()): ?>

                    <div class="all-products-card">

                        <div class="all-products-image">

                            <?php if (!empty($product['image'])): ?>

                                <img
                                    src="images/<?= htmlspecialchars($product['image']) ?>"
                                    alt="<?= htmlspecialchars($product['name']) ?>"
                                >

                            <?php else: ?>

                                <div class="all-products-no-image">
                                    <i class="fa-solid fa-box"></i>
                                </div>

                            <?php endif; ?>

                        </div>


                        <div class="all-products-info">

                            <div class="all-products-level">
                                <?= htmlspecialchars($product['edu_name']) ?>
                            </div>

                            <h3 class="all-products-name">
                                <?= htmlspecialchars($product['name']) ?>
                            </h3>

                            <?php if (!empty($product['description'])): ?>

                                <p class="all-products-description-text">
                                    <?= htmlspecialchars($product['description']) ?>
                                </p>

                            <?php endif; ?>


                            <div class="all-products-bottom">

                                <strong class="all-products-price">
                                    <?= number_format($product['price']) ?> Ks
                                </strong>


                                <?php if ($product['stock'] > 0): ?>

                                    <form
                                        action="cart.php"
                                        method="POST"
                                        class="all-products-cart-form"
                                    >

                                        <input
                                            type="hidden"
                                            name="action"
                                            value="add"
                                        >

                                        <input
                                            type="hidden"
                                            name="product_id"
                                            value="<?= $product['id'] ?>"
                                        >

                                        <button
                                            type="submit"
                                            class="all-products-cart-button"
                                        >
                                            <i class="fa-solid fa-cart-plus"></i>
                                            Add to Cart
                                        </button>

                                    </form>

                                <?php else: ?>

                                    <button
                                        type="button"
                                        class="all-products-cart-button all-products-disabled"
                                        disabled
                                    >
                                        Out of Stock
                                    </button>

                                <?php endif; ?>

                            </div>

                        </div>

                    </div>

                <?php endwhile; ?>

            <?php else: ?>

                <div class="all-products-empty">

                    <?php if ($search !== ''): ?>

                        <p>
                            No products found for
                            <strong>
                                <?= htmlspecialchars($search) ?>
                            </strong>.
                        </p>

                    <?php else: ?>

                        <p>
                            No products available yet.
                        </p>

                    <?php endif; ?>

                </div>

            <?php endif; ?>

        </div>

    </div>

</section>

<?php

include "includes/footer.php";

?>

