<template>
  <Header />
  <div class="wrapper">
    <div class="table-card">
      <div class="header-container">
        <div class="title-container">
          <h1>History</h1>
          <h2>All Orders History</h2>
        </div>
        <div class="filters">
          <div class="date-filter">
            <label for="filter-date">Filter Date:</label>
            <input type="date" v-model="filterDate" id="filter-date" />
          </div>
          <div class="user-filter">
            <label for="filter-user">Filter User</label>
            <select v-model="filterUserId" id="filter-user">
              <option value="">All Users</option>
              <option v-for="user in uniqueUsers" :key="user.id_user" :value="user.id_user">
                {{ user.nama_user }} (ID: {{ user.id_user }}) <span v-if="user.deleted_at">(Tidak Aktif)</span>
              </option>
            </select>
          </div>
        </div>
      </div>
      <div class="table-container">
        <table class="table-list">
          <thead>
            <tr>
              <td>Tanggal</td>
              <td>Kasir</td>
              <td>Pelanggan</td>
              <td>Nomor Meja</td>
              <td>Status Transaksi</td>
              <td>Actions</td>
            </tr>
          </thead>
          <tbody>
            <tr v-for="order in filteredOrders" :key="order.id_transaksi">
              <td>{{ order.tanggal_transaksi }}</td>
              <td>{{ order.detail_pegawai.nama_user }}</td>
              <td>{{ order.nama_pelanggan }}</td>
              <td>{{ order.detail_meja.nomor_meja }}</td>
              <td
                v-if="order.status === 'BELUM_BAYAR'"
                style="color: #be0000; font-weight: bold"
              >
                BELUM BAYAR
              </td>
              <td v-else style="color: green; font-weight: bold">LUNAS</td>
              <td>
                <router-link
                  class="button"
                  :to="{
                    name: 'manajerDetail',
                    params: { id: order.id_transaksi },
                  }"
                >
                  Detail
                </router-link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import { getAllOrders } from "@/stores/orders";
import Header from "../Header.vue";

export default {
  components: {
    Header,
  },
  name: "History",
  data() {
    return {
      orders: [],
      filterDate: "",
      filterUserId: "",
    };
  },
  computed: {
    filteredOrders() {
      return this.orders.filter((order) => {
        const filterDate = this.filterDate
          ? new Date(this.filterDate).toISOString().split("T")[0]
          : null;
        const transactionDate = new Date(order.tanggal_transaksi)
          .toISOString()
          .split("T")[0];
        const matchesDate = !filterDate || transactionDate === filterDate;
        const matchesUser = !this.filterUserId || order.detail_pegawai.id_user == this.filterUserId;
        return matchesDate && matchesUser;
      });
    },
    uniqueUsers() {
      const users = this.orders.map(order => order.detail_pegawai);
      const uniqueUsers = [];
      const userIds = new Set();

      users.forEach(user => {
        if (!userIds.has(user.id_user)) {
          userIds.add(user.id_user);
          uniqueUsers.push(user);
        }
      });

      return uniqueUsers;
    },
  },
  methods: {
    async fetchOrders() {
      try {
        const store = await getAllOrders();
        const data = await store.authenticate("manajer/transaksi/get");
        console.log("Fetched data:", data);
        this.orders = data;
      } catch (error) {
        console.log(error);
      }
    },
  },
  mounted() {
    this.fetchOrders();
  },
};
</script>

<style scoped>
.button {
  width: 150px;
}

.button-done {
  width: 150px;
}

td {
  padding-top: 30px;
  padding-bottom: 10px;
  border-bottom: 1px solid rgb(218, 218, 218);
  color: black;
}

.filters {
  display: flex;
  gap: 20px;
}

.date-filter,
.user-filter {
  font-weight: bold;
  margin-bottom: 20px;
}

.date-filter label,
.user-filter label {
  margin-right: 10px;
}

.date-filter input,
.user-filter select {
  margin-right: 20px;
}
</style>