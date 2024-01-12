export interface Product {
    id?: number;
    api_id?: string;
    user_id?: string;
    name: string;
    image?: string;
    country?: string;
    brand?: string;
    description?: string;
    category?: string;
    tags?: string;
    ingredients?: string;
    serving_size_unit?: string;
    serving_size?: number;
    calories?: number;
    fat?: number;
    carbohydrates?: number;
    protein?: number;
}
