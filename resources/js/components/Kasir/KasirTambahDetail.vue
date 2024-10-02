<template>
  <Header />
  <div class="wrapper">
    <div class="table-card">
      <div class="header-container">
        <h1>Add an Item</h1>
      </div>
    </div>
    <div class="table-card" >
        {{menu}}
        <div class="item-card" v-for="item in menu" :key="item.id_menu">
            <img :src="`/storage/${item.gambar}`" alt="">
            <h4>{{item.nama_menu}}</h4>
            <p>Rp. {{item.harga}}</p>
            <input type="radio" name="" id="">
        </div>

    </div>
  </div>
</template>

<script>
import Header from "../Header.vue";
import { getMenu } from "@/stores/orders";

export default {
  components: {
    Header,
  },
  name: "TambahDetail",

  data(){
    return {
        menu: [],
    };
  },

  methods: {
    async fetchMenu(){
        try{
            const store = await getMenu();
            const data = await store.authenticate("kasir/food/get");
            this.menu = data;
            // console.log(data)
        } catch (error){
            console.log(error);
        }
    }
  },

  mounted(){
    this.fetchMenu();
  }
};
</script>

<style scoped>

.header-container {
  justify-content: space-between;
  align-self: flex-start;
  display: flex;
  width: 100%;
  align-items: center;
}

td{
    border-bottom: 0px;
}

img {
  border: 1px solid #ddd;
  border-radius: 4px;
  padding: 5px;
  width: 40vh;
  height:40vh;
}

.table-card{
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 2vh;
}

/* .table-card{
    width: 80%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding-top: 50px;
    padding-bottom: 50px;
} */
</style>