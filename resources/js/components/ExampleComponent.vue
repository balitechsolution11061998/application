<template>
    <div>
      <!-- Your component HTML -->
      <h1>{{ title }}</h1>
      aaaa
      <!-- Add CRUD forms and tables here -->
    </div>
  </template>

  <script>
export default {
  data() {
    return {
      items: [],
      newItem: '',
    };
  },
  methods: {
    async fetchItems() {
      try {
        const response = await axios.get('/api/items'); // Adjust the URL to your API route
        this.items = response.data;
      } catch (error) {
        console.error(error);
      }
    },
    async createItem() {
      try {
        await axios.post('/api/items', { name: this.newItem }); // Adjust the URL and data as needed
        this.newItem = '';
        this.fetchItems();
      } catch (error) {
        console.error(error);
      }
    },
    async deleteItem(id) {
      try {
        await axios.delete(`/api/items/${id}`); // Adjust the URL as needed
        this.fetchItems();
      } catch (error) {
        console.error(error);
      }
    },
  },
  mounted() {
    this.fetchItems();
  },
};
  </script>

  <style scoped>
  /* Your component styles */
  </style>
