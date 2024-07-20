<template>
  <div>
    <form @submit.prevent="submitForm">
      <div>
        <label for="name">Campaign Name:</label>
        <input type="text" v-model="name" id="name" required>
      </div>
      <div>
        <label for="csvFile">Upload CSV File:</label>
        <input type="file" @change="handleFileUpload" id="csvFile" accept=".csv" required>
      </div>
      <button type="submit">Create Campaign</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      name: '',
      csvFile: null,
    };
  },
  methods: {
    handleFileUpload(event) {
      this.csvFile = event.target.files[0];
    },
    async submitForm() {
      const formData = new FormData();
      formData.append('name', this.name);
      formData.append('csv_file', this.csvFile);

      try {
        const response = await fetch('/api/campaigns', {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          },
          body: formData,
        });

        if (response.ok) {
          alert('Campaign created successfully!');
        } else {
          const errorData = await response.json();
          alert('Error: ' + errorData.message);
        }
      } catch (error) {
        console.error('Error:', error);
      }
    },
  },
};
</script>

<style scoped>
/* Add your styles here */
</style>
