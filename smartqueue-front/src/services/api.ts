import axios from 'axios'

export const api = axios.create({
  // Ajuste a porta ou a URL caso o seu Laragon use o domínio .test (ex: http://smartqueue-back.test/api)
  baseURL: 'http://localhost:8000/api', 
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
})