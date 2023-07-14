export interface Product {
    id: number;
    barcode?: string;
    name: string;
    brand?: string;
    image_url?: string;
    serving_size: number;
    energy: number;
    protein: number;
    total_fat: number;
    saturated_fat: number;
    carbohydrates: number;
    sugars: number;
    sodium: number;
}
