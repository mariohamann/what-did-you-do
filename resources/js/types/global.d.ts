type Category = {
    id: number;
    name: string;
    emoji: string;
};

type User = {
    id: number;
    name: string;
};

type Doing = {
    id: number;
    user: User;
    content: string;
    category_id: Category['id'];
};
