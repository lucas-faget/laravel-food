const fruits = ['apple', 'cherry', 'grape', 'kiwi', 'lemon', 'orange', 'pineapple', 'strawberry', 'watermelon'];

export const randomFruit = () => fruits[Math.floor(Math.random() * fruits.length)];

export const randomFruitImage = () => `/food/${randomFruit()}.svg`;
