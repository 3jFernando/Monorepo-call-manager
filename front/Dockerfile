FROM node:20-alpine

WORKDIR /app

# Dependencias
COPY package*.json ./
RUN npm install

# Copiar el código
COPY . .

EXPOSE 5173

# Inciar Vite
CMD ["npm", "run", "dev", "--", "--host"]