<template>
  <Header />
  <div class="wrapper">
    <div class="table-card">
      <div class="header-container">
        <h1>Add Items</h1>
      </div>
    </div>
    <div class="table-card">
      <form
        @submit.prevent="addDetails(this.$route.params.id)"
        class="ignore-form"
      >
        <div class="item-container">
          <div class="item-card" v-for="item in menu" :key="item.id_menu">
            <img :src="`/storage/${item.gambar}`" alt="" />
            <h4>{{ item.nama_menu }}</h4>
            <p>Rp. {{ item.harga.toLocaleString("id-ID") }}</p>
            <input type="checkbox" :value="item.id_menu" v-model="menu_items" />
          </div>
        </div>
        <div class="button-container">
          <button class="button">Add</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Header from "../Header.vue";
import { getMenu, addDetail } from "@/stores/orders";

export default {
  components: {
    Header,
  },
  name: "TambahDetail",

  data() {
    return {
      menu: [],
      menu_items: [],
    };
  },

  methods: {
    async fetchMenu() {
      try {
        const store = await getMenu();
        const data = await store.authenticate("kasir/food/get");
        this.menu = data;
        // console.log(data)
      } catch (error) {
        console.log(error);
      }
    },

    async addDetails($idTransaksi) {
      if (this.menu_items.length === 0) {
        alert("Please select at least one item.");
        return;
      }

      try {
        const store = await addDetail();
        // Map selected menu items to objects with the 'id_menu' key
        const formattedMenuItems = this.menu_items.map((id) => ({
          id_menu: id,
        }));

        const formData = {
          menu_items: formattedMenuItems,
        };
        await store.authenticate(
          `kasir/transaksi/detail/add/${$idTransaksi}`,
          formData
        );
      } catch (error) {
        console.log(error);
      }
    },
  },

  mounted() {
    this.fetchMenu();
  },
};
</script>

<style scoped>
.button-container {
  width: 80%;
}

input[type="checkbox"] {
  transform: scale(1.5);
}

.button-container {
  display: flex;
  justify-content: center;
  align-items: center;
}

.header-container {
  justify-content: space-between;
  align-self: flex-start;
  display: flex;
  width: 100%;
  align-items: center;
}

td {
  border-bottom: 0px;
}

img {
  border: 1px solid #ddd;
  border-radius: 4px;
  padding: 5px;
  width: 40vh;
  height: 40vh;
}

.item-container {
  /* margin-top: 7.5vh; */
  font-family: "poppins";
  padding: 50px 10vh 50px 10vh;
  /* height: auto; */
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  flex-direction: row;
  flex-wrap: wrap;
  justify-content: space-between;
  gap: 1vh;
}
</style>