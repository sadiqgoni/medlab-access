// User types
export interface User {
  id: number;
  name: string;
  email: string;
  phone?: string;
  address?: string;
  bloodType?: string;
  created_at: string;
  updated_at: string;
}

// Order types
export interface Order {
  id: number;
  user_id: number;
  type: 'test' | 'blood';
  status: 'pending' | 'confirmed' | 'in_progress' | 'completed' | 'cancelled';
  test_type?: string;
  facility_name?: string;
  facility_address?: string;
  scheduled_date?: string;
  total_amount: number;
  payment_status: 'pending' | 'paid' | 'failed';
  results_ready?: boolean;
  results_url?: string;
  created_at: string;
  updated_at: string;
}

// Dashboard stats
export interface DashboardStats {
  totalOrders: number;
  activeOrders: number;
  completedOrders: number;
  resultsReadyOrders: number;
}

// API Response types
export interface ApiResponse<T> {
  data: T;
  message?: string;
  success: boolean;
}

// Quick action types
export interface QuickAction {
  label: string;
  href: string;
  icon: React.ComponentType<any>;
  color: string;
}