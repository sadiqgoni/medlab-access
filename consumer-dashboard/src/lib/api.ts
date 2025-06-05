import axios from 'axios';
import { ApiResponse, DashboardStats, Order, User } from '@/types';

const API_BASE = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:8000/api';

const api = axios.create({
  baseURL: API_BASE,
  headers: {
    'Content-Type': 'application/json',
  },
});

// Add auth token to requests
api.interceptors.request.use((config) => {
  const token = localStorage.getItem('auth_token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

// Dashboard API calls
export const dashboardApi = {
  getStats: async (): Promise<DashboardStats> => {
    const response = await api.get<ApiResponse<DashboardStats>>('/consumer/dashboard/stats');
    return response.data.data;
  },
  
  getRecentOrders: async (limit = 5): Promise<Order[]> => {
    const response = await api.get<ApiResponse<Order[]>>(`/consumer/orders?limit=${limit}`);
    return response.data.data;
  },
};

// Orders API calls
export const ordersApi = {
  getAll: async (): Promise<Order[]> => {
    const response = await api.get<ApiResponse<Order[]>>('/consumer/orders');
    return response.data.data;
  },
  
  getById: async (id: number): Promise<Order> => {
    const response = await api.get<ApiResponse<Order>>(`/consumer/orders/${id}`);
    return response.data.data;
  },
  
  create: async (orderData: Partial<Order>): Promise<Order> => {
    const response = await api.post<ApiResponse<Order>>('/consumer/orders', orderData);
    return response.data.data;
  },
};

// User API calls
export const userApi = {
  getProfile: async (): Promise<User> => {
    const response = await api.get<ApiResponse<User>>('/consumer/profile');
    return response.data.data;
  },
  
  updateProfile: async (userData: Partial<User>): Promise<User> => {
    const response = await api.put<ApiResponse<User>>('/consumer/profile', userData);
    return response.data.data;
  },
};

export default api; 