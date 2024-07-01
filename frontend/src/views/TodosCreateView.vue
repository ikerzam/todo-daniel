<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
const todo = ref({
  title: '',
  description: ''
})

const router = useRouter()

const resultMessage = ref('')

const onSubmit = async () => {
  try {
    const response = await fetch('http://localhost:8000/api/todos', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${localStorage.getItem('token')}`
      },
      body: JSON.stringify(todo.value)
    })

    const data = await response.json()

    if (data.message) {
      resultMessage.value = data.message
      setTimeout(() => {
        router.push('/todos')
      })
    }
  } catch (error) {
    alert(error)
  }
}
</script>
<template>
  <div class="container">
    <div class="alert-success" v-if="resultMessage">{{ resultMessage }}</div>
    <form @submit.prevent="onSubmit">
      <input v-model="todo.title" placeholder="Titulo de la tarea" />
      <textarea v-model="todo.description" placeholder="Descripcion de la tarea"></textarea>
      <button type="submit">Crear Tarea</button>
    </form>
  </div>
</template>
<style scoped>
.container {
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

form {
  display: flex;
  flex-direction: column;
  gap: 1em;
  max-width: 400px;
  width: 100%;
  padding: 1em;

  & > * {
    width: 100%;
  }
}

button {
  color: white;
  padding: 0.5em;
  background-color: #47b3ec;
  outline: 0;
  border: 0;
  border-radius: 0.25em;
  cursor: pointer;
}
input,
textarea {
  width: 100%;
  padding: 0.5em;
}

textarea {
  height: 10em;
  resize: none;
}
.alert-success {
  padding: 1em;
  border: 1px solid green;
  background-color: rgb(127, 206, 127);
  border-radius: 0.5em;
  color: red;
}
</style>
