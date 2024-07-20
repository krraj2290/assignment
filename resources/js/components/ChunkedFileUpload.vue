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
      <button type="submit" :disabled="uploading">Create Campaign</button>
    </form>
    <div v-if="uploading">
      <p>Uploading: {{ Math.round(progress * 100) }}%</p>
    </div>
  </div>
</template>

<script>
import axios from '../axios';

const CHUNK_SIZE = 1 * 1024 * 1024; // 1MB

export default {
  data() {
    return {
      name: '',
      csvFile: null,
      uploading: false,
      progress: 0,
    };
  },
  methods: {
    handleFileUpload(event) {
      this.csvFile = event.target.files[0];
    },
    async uploadChunk(file, start, end, chunkIndex, totalChunks) {
      const chunk = file.slice(start, end);
      const formData = new FormData();
      formData.append('name', this.name);
      formData.append('chunk', chunk);
      formData.append('chunk_index', chunkIndex);
      formData.append('total_chunks', totalChunks);
      formData.append('file_name', file.name);

      const response = await axios.post('/upload-chunk', formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      });

      if (!response.status === 200) {
        throw new Error(`Chunk upload failed: ${response.statusText}`);
      }

      return response.data;
    },
    async submitForm() {
      if (!this.csvFile) {
        alert('Please select a file to upload.');
        return;
      }

      this.uploading = true;
      const totalChunks = Math.ceil(this.csvFile.size / CHUNK_SIZE);
      let start = 0;
      let chunkIndex = 0;

      try {
        while (start < this.csvFile.size) {
          const end = Math.min(start + CHUNK_SIZE, this.csvFile.size);
          await this.uploadChunk(this.csvFile, start, end, chunkIndex, totalChunks);
          start = end;
          chunkIndex++;
          this.progress = chunkIndex / totalChunks;
        }

        alert('Campaign created successfully!');
      } catch (error) {
        console.error('Error:', error);
        alert('Error uploading file.');
      } finally {
        this.uploading = false;
      }
    },
  },
};
</script>

<style scoped>
/* Add your styles here */
</style>
