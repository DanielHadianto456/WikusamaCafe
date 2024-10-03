import { defineStore } from "pinia";

export const getAllOrders = defineStore("getAllOrdersStore", {
    actions: {
        async authenticate(apiRoute) {
            const token = localStorage.getItem("token"); // Get the token from local storage

            const res = await fetch(`/api/${apiRoute}`, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    Authorization: `Bearer ${token}`,
                }
            });

            const data = await res.json();
            console.log(data);
            return data;
        }
    }
})

export const addOrder = defineStore("addOrderStore", {
    actions: {
        async authenticate(apiRoute, formData){
            const token = localStorage.getItem("token");

            const res = await fetch(`/api/${apiRoute}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    Authorization: `Bearer ${token}`,
                },
                body: JSON.stringify(formData),
            });

            const data = await res.json();
            console.log(data);
            this.router.push({ name: "kasirDetail", params: {id: data.id_transaksi} });
        }
    }
})

export const getAllTables = defineStore("getTableStore", {
    actions: {
        async authenticate(apiRoute) {
            const token = localStorage.getItem("token"); // Get the token from local storage

            const res = await fetch(`/api/${apiRoute}`, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    Authorization: `Bearer ${token}`,
                }
            });

            const data = await res.json();
            console.log(data);
            return data;
        }
    }
})

export const payOrder = defineStore("payOrderStore",{
    actions: {
        async authenticate(apiRoute){
            const token = localStorage.getItem("token");

            const res = await fetch(`/api/${apiRoute}`, {
                method: "PATCH",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    Authorization: `Bearer ${token}`,
                }
            });

            const data = await res.json();
            console.log(data);
            this.router.push({ name: "kasirHistory" });
        }
    }
})

export const getOrderDetail = defineStore("getOrderDetailStore", {
    actions: {
        async authenticate (apiRoute){
            const token = localStorage.getItem("token");

            const res = await fetch(`/api/${apiRoute}`, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    Authorization: `Bearer ${token}`,
                }
            });

            const data = await res.json();
            console.log(data);
            return data;
        }
    }
})

export const getOrderId = defineStore("getOrderIdStore", {
    actions: {
        async authenticate(apiRoute){
            const token = localStorage.getItem("token");

            const res = await fetch(`/api/${apiRoute}`, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    Authorization: `Bearer ${token}`,
                }
            });

            const data = await res.json();
            console.log(data);
            return data;
        }
    }
})

export const getMenu = defineStore("getMenuStore", {
    actions: {
        async authenticate(apiRoute){
            const token = localStorage.getItem("token");

            const res = await fetch(`/api/${apiRoute}`, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    Authorization: `Bearer ${token}`,
                }
            });

            const data = await res.json();
            console.log(data)
            return data;
        }
    }
})

export const addDetail = defineStore("addDetailStore",{
    actions: {
        async authenticate(apiRoute, formData){
            const token = localStorage.getItem("token");

            const res = await fetch(`/api/${apiRoute}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    Authorization: `Bearer ${token}`,
                },
                body: JSON.stringify(formData),
            });

            const data = await res.json();
            console.log(data);
            this.router.push({ name: "kasirDetail", params: {id: data.id_transaksi} });
        }
    }
})

export const deleteDetail = defineStore("deletDetailStore", {
    actions: {
        async authenticate(apiRoute){
            const token = localStorage.getItem("token");

            const res = await fetch(`/api/${apiRoute}`, {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    Authorization: `Bearer ${token}`,
                }
            });

            const data = await res.json();
            console.log(data);
            // this.router.push({ name: "kasirDetail", params: {id: data.id_transaksi} });
        }
    }
})

export const getPdf = defineStore("getPdfStore", {
    actions: {
        async authenticate(apiRoute) {
            const token = localStorage.getItem("token");

            const res = await fetch(`/api/${apiRoute}`, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    Authorization: `Bearer ${token}`,
                }
            });

            const data = await res.json();
            console.log(data);
            return data;
        },

        async downloadPdf(orderId) {
            try {
                const token = localStorage.getItem('token');
                const response = await fetch(`/api/kasir/pdf/getPdf/${orderId}`, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    },
                });

                if (!response.ok) {
                    console.error('Error fetching PDF:', response.statusText);
                    return;
                }

                const blob = await response.blob();
                const url = window.URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', `order-${orderId}.pdf`);
                document.body.appendChild(link);
                link.click();
                link.remove();
                window.URL.revokeObjectURL(url);
            } catch (error) {
                console.log(error);
            }
        }
    }
});