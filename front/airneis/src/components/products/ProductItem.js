import Product from "./Product";
import ProductH from "./ProductH";

function ProductItem({ viewType }) {
    return (
        <div
            className={
                "row row-cols-1 row-cols-md-2 row-cols-lg-2 g-3 mb-4 flex-shrink-0 " +
                (viewType.grid ? "row-cols-xl-3" : "row-cols-xl-2")
            }
        >
            {Array.from({ length: 1 }, (_, i) => {
                if (viewType.grid) {
                    return <Product key={i} percentOff={i % 2 === 0 ? 15 : null} />;
                }
                return <ProductH key={i} percentOff={i % 4 === 0 ? 15 : null} />;
            })}
        </div>
    );
}

export default ProductItem;