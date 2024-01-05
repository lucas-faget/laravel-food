import axios from "axios";

const API_BASE_URL = "http://localhost:8000/spoonacular/";

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

export async function getIngredientSearch($searchQuery: string, pageNumber: number = 1) {
    try {
        const response = await axios.get(`${API_BASE_URL}ingredients/search/${$searchQuery}/${pageNumber}`);
        return response.data.products;
    } catch (error) {
        console.error(error);
    }
}

export async function getIngredient(id: number|string) {
    try {
        const response = await axios.get(`${API_BASE_URL}ingredients/${id}`);
        return response.data;
    } catch (error) {
        console.error(error);
    }
}

export async function getProductSearch($searchQuery: string, pageNumber: number = 1) {
    try {
        const response = await axios.get(`${API_BASE_URL}products/search/${$searchQuery}/${pageNumber}`);
        console.log(response.data.products)
        return response.data.products;
    } catch (error) {
        console.error(error);
    }
}

export async function getProduct(id: number|string) {
    try {
        const response = await axios.get(`${API_BASE_URL}products/${id}`);
        return response.data;
    } catch (error) {
        console.error(error);
    }
}
