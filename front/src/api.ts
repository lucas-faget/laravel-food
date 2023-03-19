import axios from "axios";

export async function getProducts(page: number) {
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
