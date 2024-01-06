import axios from "axios";

const API_BASE_URL = "http://localhost:8000/fdc/";

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

export async function getFoodSearch($searchQuery: string, pageNumber: number = 1) {
    try {
        $searchQuery = $searchQuery ? $searchQuery : "%20";
        const response = await axios.get(`${API_BASE_URL}foods/search/${$searchQuery}/${pageNumber}`);
        return response.data;
    } catch (error) {
        console.error(error);
    }
}

export async function getFood(id: number|string) {
    try {
        const response = await axios.get(`${API_BASE_URL}food/${id}`);
        return response.data;
    } catch (error) {
        console.error(error);
    }
}
