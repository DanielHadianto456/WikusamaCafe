import { defineStore } from "pinia";

export const getAllMenu = defineStore("getAllMenuStore", {
    actions: {
        async authenticate(apiRoute) {
            const token = localStorage.getItem("token");

            const res = await fetch(`/api/${apiRoute}`, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    Authorization: `Bearer ${token}`,
                },
            });

            const data = await res.json();
            console.log(data);
            return data;
        },
    },
});

export const deleteMenu = defineStore("deletMenuStore", {
    actions: {
        async authenticate(apiRoute) {
            const token = localStorage.getItem("token");

            const res = await fetch(`/api/${apiRoute}`, {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    Authorization: `Bearer ${token}`,
                },
            });

            const data = await res.json();
            console.log(data);
        },
    },
});

// export const addMenu = defineStore("addMenuStore", {
//     actions: {
//         async authenticate(apiRoute, formData) {
//             const token = localStorage.getItem("token");

//             const res = await fetch(`/api/${apiRoute}`, {
//                 method: "POST",
//                 headers: {
//                     "Content-Type": "application/json",
//                     Accept: "application/json",
//                     Authorization: `Bearer ${token}`,
//                 },
//                 body: JSON.stringify(formData),
//             });

//             const data = await res.json();
//             console.log(data);
//             this.router.push({
//                 name: "listMenu",
//             });
//         },
//     },
// });

export const addMenu = defineStore("addMenuStore", {
    actions: {
        async authenticate(apiRoute, formData) {
            const token = localStorage.getItem("token");

            const res = await fetch(`/api/${apiRoute}`, {
                method: "POST",
                headers: {
                    Authorization: `Bearer ${token}`,
                },
                body: formData,
            });

            const data = await res.json();
            console.log(data);
            this.router.push({
                name: "menu",
            });
        },
    },
});

export const editMenu = defineStore("editMenuStore", {
    actions: {
        async authenticate(apiRoute, formData){
            const token = localStorage.getItem("token");

            const res = await fetch(`/api/${apiRoute}`, {
                method: "POST",
                headers: {
                    Authorization: `Bearer ${token}`,
                },
                body: formData,
            });

            const data = await res.json();
            console.log(data);
            this.router.push({
                name: "menu",
            });
        }
    }
})