<script setup>
import { onBeforeMount, ref, toRef } from 'vue'
const todos = ref([])
const localUser = JSON.parse(localStorage.getItem('user'))
console.log(localUser)
const user = toRef(localUser)

onBeforeMount(async () => {
  try {
    const response = await fetch('http://localhost:8000/api/todos', {
      method: 'GET',
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`
      }
    })
    if (!response.ok) throw new Error('Failed to fetch todos')
    const data = await response.json()
    todos.value = data.todos
  } catch (error) {
    alert(error.message)
  }
})

async function toggleTodo(todo) {
  try {
    const response = await fetch(`http://localhost:8000/api/todos/${todo.id}`, {
      method: 'PUT',
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        done: !todo.done
      })
    })
    if (!response.ok) throw new Error('Failed to update todo')
    const data = await response.json()
    todo.done = data.todo.done
  } catch (error) {
    alert(error.message)
  }
}

async function deleteTodo(todo) {
  try {
    const response = await fetch(`http://localhost:8000/api/todos/${todo.id}`, {
      method: 'DELETE',
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
        'Content-Type': 'application/json'
      }
    })
    if (!response.ok) throw new Error('Failed to delete todo')
    const data = await response.json()
    todos.value = todos.value.filter((t) => t.id !== todo.id)
  } catch (error) {
    alert(error.message)
  }
}
</script>

<template>
  <div class="todos">
    <h1>TODO List de {{ user.name }}</h1>
    <table>
      <thead>
        <tr>
          <th>Título</th>
          <th>Descripción</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="todo in todos" :key="todo.id">
          <td>{{ todo.title }}</td>
          <td>{{ todo.description }}</td>
          <td>{{ todo.done ? 'Terminado' : 'Pendiente' }}</td>
          <td class="actions">
            <button class="update" @click="() => toggleTodo(todo)">
              {{ todo.done ? 'Marcar como pendiente' : 'Marcar como terminado' }}
            </button>
            <button class="delete" @click="() => deleteTodo(todo)">Eliminar</button>
          </td>
        </tr>
        <tr v-if="!todos.length">
          <td colspan="4">No hay tareas</td>
        </tr>
      </tbody>
    </table>
    <RouterLink to="/todos/create">
      <button>Agregar tarea</button>
    </RouterLink>
  </div>
</template>

<style scoped>
.todos {
  padding: 20px;
  display: flex;
  flex-direction: column;
  gap: 1em;
}

h1 {
  margin: 0;
}

table {
  width: 100%;
  border-collapse: collapse;
}

th,
td {
  border: 1px solid #ddd;
  padding: 8px;
}

th {
  background-color: #f4f4f4;
}

.actions {
  display: flex;
  gap: 1em;
  align-items: center;
  justify-content: center;
}
button {
  padding: 0.5em 1em;
  border: none;
  border-radius: 0.25em;
  cursor: pointer;
}

.update {
  background-color: #47b3ec;
  color: white;
}

.delete {
  background-color: #f44336;
  color: white;
}
</style>
