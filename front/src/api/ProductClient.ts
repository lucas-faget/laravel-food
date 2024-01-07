import axios from 'axios';
import type { Product } from '../types/Product';

const API_BASE_URL = "http://localhost:8000/api";

export const getProductPage = async (pageNumber: number = 1) => {
    try {
        const response = await axios.get(`${API_BASE_URL}/products/page/${pageNumber}`);
        return response.data;
    } catch (error) {
        console.error(error);
        throw error;
    }
};

export const getProductById = async (productId: string|number) => {
    try {
        const response = await axios.get(`${API_BASE_URL}/products/${productId}`);
        return response.data;
    } catch (error) {
        console.error(error);
        throw error;
    }
};

export const createProduct = async (product: Product) => {
    try {
        console.log(JSON.stringify(product))
        const response = await axios.post(`${API_BASE_URL}/products`, product);
        return response.data;
    } catch (error) {
        console.error(error);
        throw error;
    }
};

export const updateProduct = async (product: Product) => {
    try {
        const response = await axios.put(`${API_BASE_URL}/products/${product.id}`, product);
        return response.data;
    } catch (error) {
        console.error(error);
        throw error;
    }
};

export const deleteProduct = async (productId: number) => {
    try {
        await axios.delete(`${API_BASE_URL}/${productId}`);
    } catch (error) {
        console.error(error);
        throw error;
    }
};
