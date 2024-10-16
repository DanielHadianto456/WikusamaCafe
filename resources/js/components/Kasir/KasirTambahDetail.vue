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
            <p>Rp. {{ item.harga.toLocaleString('id-ID') }}</p>
            <!-- Checkbox to select the item -->
            <input
              type="checkbox"
              :value="item.id_menu"
              v-model="menu_items"
              @change="handleSelection(item.id_menu)" 
            />
            <!-- Show the quantity input only if the item is selected -->
            <div v-if="menu_items.includes(item.id_menu)">
              <input
                type="number"
                v-model.number="quantities[item.id_menu]"
                min="1"
                placeholder="Quantity"
              />
            </div>
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
      menu: [], // Stores menu items fetched from the backend
      menu_items: [], // Stores selected menu items (by ID)
      quantities: {}, // Stores quantities for each selected item
    };
  },

  methods: {
    async fetchMenu() {
      try {
        const store = await getMenu();
        const data = await store.authenticate("kasir/food/get");
        this.menu = data;
      } catch (error) {
        console.log(error);
      }
    },

    handleSelection(id_menu) {
      // Initialize quantity to 1 when an item is selected
      if (this.menu_items.includes(id_menu) && !this.quantities[id_menu]) {
        this.quantities[id_menu] = 1;
      }
    },

    async addDetails($idTransaksi) {
      if (this.menu_items.length === 0) {
        alert("Please select at least one item.");
        return;
      }

      try {
        const store = await addDetail();

        // Create the formatted array for 'menu_items'
        const formattedMenuItems = [];

        // Iterate over selected menu items and add objects based on quantity
        this.menu_items.forEach((id_menu) => {
          const quantity = this.quantities[id_menu] || 1; // Default to 1 if no quantity is specified
          
          // Add 'id_menu' object multiple times based on the quantity
          for (let i = 0; i < quantity; i++) {
            formattedMenuItems.push({ id_menu });
          }
        });

        const formData = {
          menu_items: formattedMenuItems,
        };

        // Send request to add transaction details
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
  font-family: "poppins";
  padding: 50px 10vh 50px 10vh;
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
