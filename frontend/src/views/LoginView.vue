<script setup>
import { ref, reactive, computed, watch } from 'vue'
import { useRouter } from 'vue-router'
const email = ref('')
const password = ref('')
const router = useRouter()

const viewPassword = ref('text')

const onClickPassword = () => {
  viewPassword.value = viewPassword.value === 'text' ? 'password' : 'text'
}

const validate = async () => {
  if (!email.value) {
    alert('Email is required')
    return
  }
  if (!password.value) {
    alert('Password is required')
    return
  }

  try {
    const res = await fetch('http://localhost:8000/api/login', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ email: email.value, password: password.value })
    })

    if (!res.ok) {
      const errorData = await res.json()
      alert(errorData.message || 'Login failed')
      return
    }

    const data = await res.json()
    if (data.access_token) {
      localStorage.setItem('token', data.access_token)
      localStorage.setItem('user', JSON.stringify(data.user))
      router.push('/todos')
    }
  } catch (error) {
    alert('An error occurred: ' + error.message)
  }
}
</script>

<template>
  <div>
    <form @submit.prevent="validate">
      <input type="text" v-model="email" placeholder="email@example.com" />
      <div class="password">
        <input :type="viewPassword" v-model="password" placeholder="*********" />
        <button type="button" @click="onClickPassword">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
            <path
              fill="currentColor"
              d="M12 9a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3m0 8a5 5 0 0 1-5-5a5 5 0 0 1 5-5a5 5 0 0 1 5 5a5 5 0 0 1-5 5m0-12.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5"
            />
          </svg>
        </button>
      </div>
      <button type="submit">Login</button>
    </form>
  </div>
</template>

<style scoped>
form {
  height: 100vh;
  display: grid;
  flex-direction: column;
  place-content: center;
  gap: 1em;
}

input {
  outline: none;
  border: 1px solid #ccc;
  padding: 0.75em;
  border-radius: 0.5em;
}

.password {
  display: flex;
  gap: 0.5em;
  background-color: #fff;
  border: 1px solid #ccc;
  padding: 0.5em;
  border-radius: 0.5em;
  & button {
    background-color: #fff;
    border: none;
    cursor: pointer;
  }
  & input {
    border: 0;
    padding: 0;
  }
}
[type='submit'] {
  cursor: pointer;
  background-color: #47b3ec;
  color: white;
  border: none;
  padding: 0.5em;
  border-radius: 0.5em;
}
</style>
