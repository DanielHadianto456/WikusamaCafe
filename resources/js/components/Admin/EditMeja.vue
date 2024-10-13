<template>
  <Header />

  <div class="wrapper">
    <div class="card">
      <div class="header-container">
        <h1>Edit Meja</h1>
      </div>
    </div>
    <div class="card">
      <div class="table-container">
        <form @submit.prevent="update">
          <table class="table-list">
            <thead></thead>
            <tbody>
              <tr>
                <td>Nomor Meja</td>
              </tr>
              <tr>
                <td>
                  <input type="text" v-model="formData.nomor_meja" required />
                </td>
              </tr>
              <tr>
                <td>
                  <button class="button">Edit Meja</button>
                </td>
              </tr>
            </tbody>
          </table>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import Header from "../Header.vue";
import { editMeja } from "@/stores/meja";

export default {
  components: {
    Header,
  },
  name: "UpdateMeja",

  data() {
    return {
      formData: {
        nomor_meja: "",
      },
    };
  },

  methods: {
    async update() {
      try {
        const formData = new FormData();
        formData.append("nomor_meja", this.formData.nomor_meja);
        const store = editMeja();
        await store.authenticate(`admin/meja/update/${this.$route.params.id}`, formData);
      } catch (error) {
        console.log(error);
      }
    },
  },
};
</script>