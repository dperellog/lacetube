import { defineStore } from 'pinia'
import Auth from '@/services/Auth'
import router from '@/router/index'
import CryptoJS from 'crypto-js'

const KEY = "AMZchT433HOauyXLW0UJQrXEFvsBdTRu"

export const useUserStore = defineStore('user', {
  state: () => ({
    user: JSON.parse(localStorage.getItem('lacetubeUser')),
    role: 'admin'
    
  }),
  getters: {
    currentUser: (state) => state.user,
    isLogged: (state) => state.user !== null,
    canAccessGestio: (state) => ['admin', 'teacher'].includes(state.role)
  },
  actions: {
    loginUser(user) {
      this.user = user;
      localStorage.setItem('lacetubeUser', JSON.stringify(user));
      router.push('/tauler')
    },
    logout() {
      Auth.logout()
        .then(() => {
          this.user = null;
          localStorage.removeItem('lacetubeUser');
        })
        .then(() => router.push('/'))
        .catch((error) => {
          if (error.response.status == 401) {
            this.user = null;
            localStorage.removeItem('lacetubeUser');
          }
          console.log('error :>> ', error);
        })
    }
  },
})

function encrypt(data) {
  // Cifrar los datos con AES y la clave secreta
  const ciphertext = CryptoJS.AES.encrypt(JSON.stringify(data), KEY).toString();

  let encData = CryptoJS.enc.Base64.stringify(CryptoJS.enc.Utf8.parse(ciphertext))


  return JSON.stringify(encData);
}

// Función para descifrar los datos y verificar la firma digital
function decrypt(encryptedDataString) {
  // Convertir la cadena JSON a un objeto
  const encryptedData = JSON.parse(encryptedDataString);

  // Verificar la firma digital con HMAC y la clave secreta
  const hmac = CryptoJS.HmacSHA256(encryptedData.data, KEY);
  if (hmac.toString() !== encryptedData.hmac) {
    throw new Error('La firma digital es inválida');
  }

  // Descifrar los datos con AES y la clave secreta
  const ciphertext = CryptoJS.lib.CipherParams.create({
    ciphertext: CryptoJS.enc.Base64.parse(encryptedData.data),
    iv: CryptoJS.enc.Hex.parse(encryptedData.iv),
  });
  const jsonData = CryptoJS.AES.decrypt(ciphertext, KEY, {
    iv: CryptoJS.enc.Hex.parse(encryptedData.iv),
  }).toString(CryptoJS.enc.Utf8);

  // Convertir los datos de vuelta a un objeto
  const data = JSON.parse(jsonData);

  return data;
}