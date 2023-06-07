import axios from "axios";

export const fakeProducts = (productNumber: number) => {
    let products = [];
    for (let i=1 ; i <= productNumber ; i++) {
        products.push({
            code: i,
            product_name: "Product name",
            brands: "Brand",
            image_url: "https://picsum.photos/200/300"
        });
    }
    return products;
}

export async function getProducts(page: number = 1) {
    try {
        const response = await axios.get(`http://localhost:8000/api/products/${page}`);
        return response.data.products;
    } catch (error) {
        console.error(error);
    }
}

export async function getProduct(barcode: number) {
    try {
        const response = await axios.get(`http://localhost:8000/api/products/code/${barcode}`);
        return response.data.product;
    } catch (error) {
        console.error(error);
    }
}

export async function getFilteredProducts(search: string, page: number = 1) {
    try {
        const response = await axios.get(`http://localhost:8000/api/products/search/${search}/${page}`);
        return response.data.products;
    } catch (error) {
        console.error(error);
    }
}
