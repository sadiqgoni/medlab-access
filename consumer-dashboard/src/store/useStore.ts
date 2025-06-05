import { create } from 'zustand';
import { User, Order, DashboardStats } from '@/types';
import { dashboardApi, ordersApi, userApi } from '@/lib/api';

interface DashboardStore {
  // State
  user: User | null;
  stats: DashboardStats | null;
  orders: Order[];
  recentOrders: Order[];
  loading: boolean;
  error: string | null;

  // Actions
  setUser: (user: User | null) => void;
  fetchDashboardData: () => Promise<void>;
  fetchOrders: () => Promise<void>;
  setLoading: (loading: boolean) => void;
  setError: (error: string | null) => void;
  reset: () => void;
}

// Mock data for development
const mockUser: User = {
  id: 1,
  name: 'John Doe',
  email: 'john@example.com',
  phone: '+234 123 456 7890',
  address: '123 Lagos Street, Victoria Island, Lagos',
  bloodType: 'O+',
  created_at: '2024-01-01T00:00:00Z',
  updated_at: '2024-01-01T00:00:00Z',
};

const mockStats: DashboardStats = {
  totalOrders: 12,
  activeOrders: 3,
  completedOrders: 8,
  resultsReadyOrders: 2,
};

const mockOrders: Order[] = [
  {
    id: 1,
    user_id: 1,
    type: 'test',
    status: 'completed',
    test_type: 'Full Blood Count',
    facility_name: 'Lagos Medical Center',
    facility_address: 'Victoria Island, Lagos',
    scheduled_date: '2024-01-15T10:00:00Z',
    total_amount: 15000,
    payment_status: 'paid',
    results_ready: true,
    results_url: '/results/1.pdf',
    created_at: '2024-01-10T00:00:00Z',
    updated_at: '2024-01-15T00:00:00Z',
  },
  {
    id: 2,
    user_id: 1,
    type: 'blood',
    status: 'in_progress',
    test_type: 'Blood Donation',
    facility_name: 'Abuja Blood Bank',
    facility_address: 'Central Area, Abuja',
    scheduled_date: '2024-01-20T14:00:00Z',
    total_amount: 0,
    payment_status: 'paid',
    results_ready: false,
    created_at: '2024-01-18T00:00:00Z',
    updated_at: '2024-01-18T00:00:00Z',
  },
  {
    id: 3,
    user_id: 1,
    type: 'test',
    status: 'pending',
    test_type: 'Lipid Profile',
    facility_name: 'Kano Diagnostic Center',
    facility_address: 'Sabon Gari, Kano',
    scheduled_date: '2024-01-25T09:00:00Z',
    total_amount: 12000,
    payment_status: 'pending',
    results_ready: false,
    created_at: '2024-01-20T00:00:00Z',
    updated_at: '2024-01-20T00:00:00Z',
  },
  {
    id: 4,
    user_id: 1,
    type: 'test',
    status: 'completed',
    test_type: 'Blood Glucose',
    facility_name: 'Port Harcourt Lab',
    facility_address: 'GRA, Port Harcourt',
    total_amount: 8000,
    payment_status: 'paid',
    results_ready: true,
    results_url: '/results/4.pdf',
    created_at: '2024-01-05T00:00:00Z',
    updated_at: '2024-01-08T00:00:00Z',
  },
];

export const useStore = create<DashboardStore>((set, get) => ({
  // Initial state
  user: null,
  stats: null,
  orders: [],
  recentOrders: [],
  loading: false,
  error: null,

  // Actions
  setUser: (user) => set({ user }),
  
  setLoading: (loading) => set({ loading }),
  
  setError: (error) => set({ error }),

  fetchDashboardData: async () => {
    set({ loading: true, error: null });
    try {
      // Use mock data for now - replace with real API calls later
      await new Promise(resolve => setTimeout(resolve, 800)); // Simulate API delay
      
      set({
        stats: mockStats,
        recentOrders: mockOrders.slice(0, 5),
        user: mockUser,
        loading: false,
      });
    } catch (error) {
      // Fallback to mock data if API fails
      set({
        stats: mockStats,
        recentOrders: mockOrders.slice(0, 5),
        user: mockUser,
        loading: false,
        error: null, // Don't show error for now
      });
    }
  },

  fetchOrders: async () => {
    set({ loading: true, error: null });
    try {
      // Use mock data for now - replace with real API calls later
      await new Promise(resolve => setTimeout(resolve, 600)); // Simulate API delay
      
      set({ orders: mockOrders, loading: false });
    } catch (error) {
      // Fallback to mock data if API fails
      set({ 
        orders: mockOrders,
        loading: false,
        error: null, // Don't show error for now
      });
    }
  },

  reset: () => set({
    user: null,
    stats: null,
    orders: [],
    recentOrders: [],
    loading: false,
    error: null,
  }),
})); 