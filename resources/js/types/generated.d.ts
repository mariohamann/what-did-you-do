export type ActionData = {
    id: number;
    user: UserData;
    description: string;
    created_at: string;
    likes: ActionLikesData;
    category: CategoryData;
    lat: number;
    lng: number;
};
export type ActionIndexData = {
    actions: {
        data: Array<ActionData>;
        links: Array<any>;
        meta: {
            path: string;
            per_page: number;
            next_cursor: string | null;
            next_cursor_url: string | null;
            prev_cursor: string | null;
            prev_cursor_url: string | null;
        };
    };
    actions_json_url: string;
};
export type ActionLikesData = {
    total: number;
    liked: boolean;
};
export type ActionsJsonData = {
    id: number;
    ca: number;
    la: number;
    ln: number;
};
export type CategoryData = {
    id: number;
    name: string;
    emoji: string;
    slug: string;
};
export type UserData = {
    id: number;
    name: string;
};
export type WelcomeData = {
    canLogin: boolean;
    canRegister: boolean;
    laravelVersion: string;
    phpVersion: string;
};
