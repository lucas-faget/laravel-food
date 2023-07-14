import axios from "axios";

const API_BASE_URL = "http://localhost:8000/api/products";

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

export async function getOpenProducts(page: number = 1) {
    try {
        const response = await axios.get(`${API_BASE_URL}/${page}`);
        return response.data.products;
    } catch (error) {
        console.error(error);
    }
}

export async function getOpenProduct(barcode: number) {
    try {
        const response = await axios.get(`${API_BASE_URL}/${barcode}`);
        return response.data.product;
    } catch (error) {
        console.error(error);
    }
}

export async function getFilteredOpenProducts(search: string, page: number = 1) {
    try {
        const response = await axios.get(`${API_BASE_URL}/search/${search}/${page}`);
        return response.data.products;
    } catch (error) {
        console.error(error);
    }
}
