import { defineConfig } from "vite";
import path from "path";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import watchAndRun from "vite-plugin-watch-and-run";

export default defineConfig({
    plugins: [
        watchAndRun([
            {
                name: "gen",
                watchKind: ["add", "change", "unlink"],
                watch: path.resolve("app/{Data,Enums}/**/*.php"),
                run: "pnpm generate-types",
            },
        ]),
        laravel({
            input: "resources/js/app.ts",
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
