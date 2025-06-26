"use client"

import type React from "react"
import { useEffect, useState } from "react"
import Link from "next/link"

import { 
  PlusIcon, 
  FunnelIcon, 
  MagnifyingGlassIcon, 
  BeakerIcon, 
  HeartIcon, 
  ClockIcon, 
  CheckCircleIcon, 
  DocumentArrowDownIcon, 
  ChevronDownIcon, 
  XMarkIcon, 
  SparklesIcon, 
  EyeIcon, 
  CalendarDaysIcon, 
  CreditCardIcon, 
  ArrowPathIcon 
} from "@heroicons/react/24/outline"

// Mock data for demonstration
const mockOrders = [
  {
    id: 1,
    test_type: 'Complete Blood Count (CBC)',
    type: 'test',
    status: 'completed',
    facility_name: 'HealthLab Central',
    created_at: '2024-01-15T10:30:00Z',
    scheduled_date: '2024-01-16T09:00:00Z',
    total_amount: 35000,
    payment_status: 'paid',
    results_ready: true,
    results_url: '/results/1'
  },
  {
    id: 2,
    test_type: 'Blood Donation',
    type: 'blood',
    status: 'in_progress',
    facility_name: 'City Blood Bank',
    created_at: '2024-01-14T14:20:00Z',
    scheduled_date: '2024-01-17T11:00:00Z',
    total_amount: 0,
    payment_status: 'paid',
    results_ready: false,
    results_url: null
  },
  {
    id: 3,
    test_type: 'Lipid Panel',
    type: 'test',
    status: 'pending',
    facility_name: 'MedTest Pro',
    created_at: '2024-01-13T16:45:00Z',
    scheduled_date: '2024-01-18T08:30:00Z',
    total_amount: 45000,
    payment_status: 'pending',
    results_ready: false,
    results_url: null
  },
  {
    id: 4,
    test_type: 'Thyroid Function Test',
    type: 'test',
    status: 'completed',
    facility_name: 'HealthLab Central',
    created_at: '2024-01-10T09:15:00Z',
    scheduled_date: '2024-01-12T10:00:00Z',
    total_amount: 38000,
    payment_status: 'paid',
    results_ready: true,
    results_url: '/results/4'
  }
];

const statusColors = {
  pending: 'bg-gradient-to-r from-amber-100 to-yellow-100 text-amber-800 border-amber-200',
  confirmed: 'bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border-blue-200',
  in_progress: 'bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-800 border-blue-200',
  completed: 'bg-gradient-to-r from-emerald-100 to-green-100 text-emerald-800 border-emerald-200',
  cancelled: 'bg-gradient-to-r from-red-100 to-pink-100 text-red-800 border-red-200',
};

const statusIcons = {
  pending: ClockIcon,
  confirmed: ClockIcon,
  in_progress: ArrowPathIcon,
  completed: CheckCircleIcon,
  cancelled: XMarkIcon,
};

const formatDate = (dateString: string) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  });
};

const formatCurrency = (amount: number) => {
  return new Intl.NumberFormat('en-NG', {
    style: 'currency',
    currency: 'NGN'
  }).format(amount);
};

export default function OrdersPage() {
  const [orders] = useState(mockOrders);
  const [loading, setLoading] = useState(true);
  const [searchTerm, setSearchTerm] = useState('');
  const [statusFilter, setStatusFilter] = useState<string>('all');
  const [typeFilter, setTypeFilter] = useState<string>('all');
  const [showFilters, setShowFilters] = useState(false);

  useEffect(() => {
    // Simulate loading
    const timer = setTimeout(() => setLoading(false), 1000);
    return () => clearTimeout(timer);
  }, []);

  const filteredOrders = orders.filter((order) => {
    const matchesSearch = order.test_type?.toLowerCase().includes(searchTerm.toLowerCase()) ||
                         order.facility_name?.toLowerCase().includes(searchTerm.toLowerCase()) ||
                         order.id.toString().includes(searchTerm);
    
    const matchesStatus = statusFilter === 'all' || order.status === statusFilter;
    const matchesType = typeFilter === 'all' || order.type === typeFilter;
    
    return matchesSearch && matchesStatus && matchesType;
  });

  const activeFiltersCount = (statusFilter !== 'all' ? 1 : 0) + (typeFilter !== 'all' ? 1 : 0);

  if (loading) {
    return (
      <div className="flex items-center justify-center min-h-64 px-4">
        <div className="relative">
          <div className="animate-spin rounded-full h-12 w-12 border-4 border-blue-100"></div>
          <div className="animate-spin rounded-full h-12 w-12 border-4 border-blue-600 border-t-transparent absolute top-0 left-0"></div>
          <div className="absolute inset-0 flex items-center justify-center">
            <SparklesIcon className="h-5 w-5 text-blue-600 animate-pulse" />
          </div>
        </div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/50">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 lg:py-6">
        <div className="space-y-6">
          {/* Premium Header */}
          <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
              <h1 className="font-bold text-2xl sm:text-3xl text-gray-900 leading-tight tracking-tight">
                My Orders
              </h1>
              <p className="text-gray-600 text-sm sm:text-base font-medium mt-1">
                Track and manage your medical service requests
              </p>
            </div>
            <Link href="/orders/create" className="group inline-flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 border border-transparent rounded-xl font-semibold text-sm text-white hover:from-blue-700 hover:via-blue-800 hover:to-indigo-800 focus:outline-none focus:ring-4 focus:ring-blue-500/25 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
              <PlusIcon className="w-4 h-4 mr-2" />
              New Order
            </Link>
          </div>

          {/* Main Content Card - Starting from Search Bar */}
          <div className="relative overflow-hidden bg-white rounded-2xl shadow-xl border border-gray-100 p-4 sm:p-6">
            {/* Subtle decorative background */}
            <div className="absolute inset-0 bg-gradient-to-br from-blue-50/30 via-white to-indigo-50/30"></div>
            <div className="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-100/20 to-indigo-100/20 rounded-full blur-2xl -translate-y-16 translate-x-16"></div>
            <div className="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-teal-100/20 to-blue-100/20 rounded-full blur-2xl translate-y-12 -translate-x-12"></div>
            
            <div className="relative space-y-6">
              {/* Premium Search Bar */}
              <div className="relative group">
                <div className="absolute inset-0 bg-gradient-to-r from-blue-600/10 to-indigo-600/10 rounded-xl blur opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div className="relative bg-white/80 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 hover:border-blue-300 transition-all duration-300">
                  <MagnifyingGlassIcon className="absolute left-4 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400 group-hover:text-blue-500 transition-colors duration-300" />
                  <input
                    type="text"
                    placeholder="Search orders by test type, facility, or order number..."
                    value={searchTerm}
                    onChange={(e) => setSearchTerm(e.target.value)}
                    className="w-full pl-12 pr-4 py-4 bg-transparent rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-500/25 text-gray-900 placeholder-gray-500"
                  />
                </div>
              </div>

              {/* Premium Filters Section */}
              <div className="bg-white/60 backdrop-blur-sm rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
                <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                  {/* Mobile Filter Toggle */}
                  <button
                    onClick={() => setShowFilters(!showFilters)}
                    className="sm:hidden inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 hover:from-gray-100 hover:to-gray-200 focus:outline-none focus:ring-4 focus:ring-blue-500/25 transition-all duration-200"
                  >
                    <FunnelIcon className="w-4 h-4 mr-2" />
                    Filters
                    {activeFiltersCount > 0 && (
                      <span className="ml-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-xs rounded-full px-2.5 py-1 font-bold shadow-sm">
                        {activeFiltersCount}
                      </span>
                    )}
                    <ChevronDownIcon className={`w-4 h-4 ml-2 transform transition-transform duration-200 ${showFilters ? 'rotate-180' : ''}`} />
                  </button>

                  {/* Desktop Filters */}
                  <div className="hidden sm:flex items-center space-x-4">
                    <div className="flex items-center space-x-2">
                      <FunnelIcon className="h-5 w-5 text-gray-400" />
                      <span className="text-sm font-medium text-gray-700">Filter by:</span>
                    </div>
                    <select
                      value={statusFilter}
                      onChange={(e) => setStatusFilter(e.target.value)}
                      className="border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-medium focus:ring-4 focus:ring-blue-500/25 focus:border-blue-300 bg-white hover:bg-gray-50 transition-all duration-200"
                    >
                      <option value="all">All Status</option>
                      <option value="pending">Pending</option>
                      <option value="confirmed">Confirmed</option>
                      <option value="in_progress">In Progress</option>
                      <option value="completed">Completed</option>
                      <option value="cancelled">Cancelled</option>
                    </select>
                    <select
                      value={typeFilter}
                      onChange={(e) => setTypeFilter(e.target.value)}
                      className="border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-medium focus:ring-4 focus:ring-blue-500/25 focus:border-blue-300 bg-white hover:bg-gray-50 transition-all duration-200"
                    >
                      <option value="all">All Types</option>
                      <option value="test">Lab Tests</option>
                      <option value="blood">Blood Services</option>
                    </select>
                  </div>

                  <div className="hidden sm:flex items-center space-x-4">
                    <div className="text-sm font-medium text-gray-600 bg-gray-50 px-3 py-2 rounded-lg">
                      <span className="text-gray-900 font-bold">{filteredOrders.length}</span> of <span className="text-gray-900 font-bold">{orders.length}</span> orders
                    </div>
                  </div>
                </div>

                {/* Mobile Filters Dropdown */}
                {showFilters && (
                  <div className="sm:hidden mt-4 p-4 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl border border-gray-200">
                    <div className="flex items-center justify-between mb-4">
                      <h3 className="font-bold text-gray-900">Filter Orders</h3>
                      <button
                        onClick={() => setShowFilters(false)}
                        className="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-white rounded-lg transition-all duration-200"
                      >
                        <XMarkIcon className="w-5 h-5" />
                      </button>
                    </div>
                    
                    <div className="space-y-4">
                      <div>
                        <label className="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                        <select
                          value={statusFilter}
                          onChange={(e) => setStatusFilter(e.target.value)}
                          className="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-blue-500/25 focus:border-blue-300 bg-white"
                        >
                          <option value="all">All Status</option>
                          <option value="pending">Pending</option>
                          <option value="confirmed">Confirmed</option>
                          <option value="in_progress">In Progress</option>
                          <option value="completed">Completed</option>
                          <option value="cancelled">Cancelled</option>
                        </select>
                      </div>
                      
                      <div>
                        <label className="block text-sm font-semibold text-gray-700 mb-2">Type</label>
                        <select
                          value={typeFilter}
                          onChange={(e) => setTypeFilter(e.target.value)}
                          className="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-blue-500/25 focus:border-blue-300 bg-white"
                        >
                          <option value="all">All Types</option>
                          <option value="test">Lab Tests</option>
                          <option value="blood">Blood Services</option>
                        </select>
                      </div>

                      {activeFiltersCount > 0 && (
                        <button
                          onClick={() => {
                            setStatusFilter('all');
                            setTypeFilter('all');
                          }}
                          className="w-full px-4 py-3 text-sm font-semibold text-gray-600 hover:text-gray-800 border border-gray-300 rounded-xl hover:bg-white transition-all duration-200"
                        >
                          Clear All Filters
                        </button>
                      )}
                    </div>
                  </div>
                )}
              </div>

              {/* Results Count - Mobile */}
              <div className="sm:hidden text-center">
                <div className="inline-flex items-center px-4 py-2 bg-white/80 backdrop-blur-sm rounded-xl shadow-sm border border-gray-100">
                  <span className="text-sm font-medium text-gray-600">
                    <span className="text-gray-900 font-bold">{filteredOrders.length}</span> of <span className="text-gray-900 font-bold">{orders.length}</span> orders
                  </span>
                </div>
              </div>

              {/* Premium Orders List */}
              {filteredOrders.length === 0 ? (
                <div className="relative overflow-hidden bg-white/60 backdrop-blur-sm rounded-2xl shadow-sm border border-gray-100 p-8 sm:p-12 text-center">
                  <div className="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-indigo-50/50"></div>
                  <div className="relative">
                    <div className="h-16 w-16 mx-auto mb-6 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-2xl flex items-center justify-center">
                      <BeakerIcon className="h-8 w-8 text-blue-600" />
                    </div>
                    <h3 className="text-xl font-bold text-gray-900 mb-3">No orders found</h3>
                    <p className="text-gray-600 mb-8 max-w-md mx-auto">
                      {orders.length === 0 
                        ? "You haven't placed any orders yet. Start your health journey today!" 
                        : "No orders match your search criteria. Try adjusting your filters."
                      }
                    </p>
                    <Link href="/orders/create" className="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:scale-105">
                      <PlusIcon className="w-5 h-5 mr-2" />
                      Place Your First Order
                    </Link>
                  </div>
                </div>
              ) : (
                <div>
                  {/* Card Header */}
                  <div className="flex items-center justify-between mb-6">
                    <div>
                      <h2 className="text-xl font-bold text-gray-900 mb-1">Your Orders</h2>
                      <p className="text-sm text-gray-600">
                        {filteredOrders.length} {filteredOrders.length === 1 ? 'order' : 'orders'} found
                      </p>
                    </div>
                    <div className="text-sm font-medium text-gray-500 bg-gray-50 px-3 py-2 rounded-lg">
                      {filteredOrders.length} of {orders.length}
                    </div>
                  </div>

                  <div className="space-y-4">
                    {/* Desktop: Premium Card Layout */}
                    <div className="hidden lg:block space-y-4">
                      {filteredOrders.map((order, index) => {
                        const StatusIcon = statusIcons[order.status as keyof typeof statusIcons];
                        return (
                          <div 
                            key={order.id} 
                            className="group relative overflow-hidden bg-white/80 backdrop-blur-sm rounded-xl shadow-sm hover:shadow-lg border border-gray-100 hover:border-blue-200 transition-all duration-300 transform hover:scale-[1.01]"
                            style={{ animationDelay: `${index * 100}ms` }}
                          >
                            <div className="absolute inset-0 bg-gradient-to-r from-blue-50/0 via-blue-50/0 to-indigo-50/0 group-hover:from-blue-50/20 group-hover:via-blue-50/10 group-hover:to-indigo-50/20 transition-all duration-500"></div>
                            
                            <div className="relative p-5">
                              <div className="flex items-center justify-between">
                                <div className="flex items-center space-x-5 flex-1 min-w-0">
                                  {/* Premium Order Icon */}
                                  <div className={`relative h-12 w-12 rounded-xl flex items-center justify-center flex-shrink-0 shadow-md group-hover:scale-110 transition-transform duration-300 ${
                                    order.type === 'test' 
                                      ? 'bg-gradient-to-br from-blue-100 to-blue-200' 
                                      : 'bg-gradient-to-br from-red-100 to-red-200'
                                  }`}>
                                    {order.type === 'test' ? (
                                      <BeakerIcon className="h-6 w-6 text-blue-600" />
                                    ) : (
                                      <HeartIcon className="h-6 w-6 text-red-600" />
                                    )}
                                    <div className="absolute -top-1 -right-1 h-4 w-4 bg-gradient-to-r from-green-400 to-green-500 rounded-full border-2 border-white flex items-center justify-center">
                                      <div className="h-1.5 w-1.5 bg-white rounded-full"></div>
                                    </div>
                                  </div>

                                  {/* Order Details */}
                                  <div className="flex-1 min-w-0">
                                    <div className="flex items-center space-x-3 mb-2">
                                      <h3 className="text-lg font-bold text-gray-900 truncate">
                                        {order.test_type || `${order.type === 'test' ? 'Lab Test' : 'Blood Service'}`}
                                      </h3>
                                      <span className={`inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold flex-shrink-0 border shadow-sm ${statusColors[order.status as keyof typeof statusColors]}`}>
                                        <StatusIcon className="w-3 h-3 mr-1" />
                                        {order.status.replace('_', ' ').toUpperCase()}
                                      </span>
                                    </div>
                                    <div className="flex items-center space-x-4 text-sm text-gray-600 mb-1">
                                      <div className="flex items-center space-x-1">
                                        <span className="font-semibold text-gray-900">#{order.id}</span>
                                      </div>
                                      <div className="flex items-center space-x-1">
                                        <span className="truncate font-medium">{order.facility_name}</span>
                                      </div>
                                      <div className="flex items-center space-x-1">
                                        <CalendarDaysIcon className="h-4 w-4 text-gray-400" />
                                        <span>{formatDate(order.created_at)}</span>
                                      </div>
                                    </div>
                                    {order.scheduled_date && (
                                      <div className="flex items-center space-x-2 text-sm text-blue-600 bg-blue-50 px-2.5 py-1 rounded-lg inline-flex">
                                        <ClockIcon className="h-3 w-3" />
                                        <span className="font-medium">Scheduled: {formatDate(order.scheduled_date)}</span>
                                      </div>
                                    )}
                                  </div>
                                </div>

                                {/* Premium Actions */}
                                <div className="flex items-center space-x-5 flex-shrink-0">
                                  <div className="text-right">
                                    <div className="text-xl font-bold text-gray-900 mb-1">
                                      {formatCurrency(order.total_amount)}
                                    </div>
                                    <div className={`inline-flex items-center px-2 py-1 rounded-lg text-xs font-semibold ${
                                      order.payment_status === 'paid' ? 'bg-green-100 text-green-800' :
                                      order.payment_status === 'failed' ? 'bg-red-100 text-red-800' :
                                      'bg-yellow-100 text-yellow-800'
                                    }`}>
                                      <CreditCardIcon className="h-3 w-3 mr-1" />
                                      {order.payment_status.toUpperCase()}
                                    </div>
                                  </div>

                                  <div className="flex items-center space-x-2">
                                    {order.results_ready && order.results_url && (
                                      <Link href={`/orders/${order.id}/results`} className="p-2.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200 hover:scale-110 shadow-sm hover:shadow-md">
                                        <DocumentArrowDownIcon className="h-4 w-4" />
                                      </Link>
                                    )}
                                    <Link href={`/orders/${order.id}`} className="px-4 py-2 text-sm font-semibold text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200 border border-blue-200 hover:border-blue-300">
                                      <EyeIcon className="h-4 w-4 mr-1.5 inline" />
                                      View Details
                                    </Link>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        );
                      })}
                    </div>

                    {/* Mobile & Tablet: Premium Card Layout */}
                    <div className="lg:hidden space-y-4">
                      {filteredOrders.map((order, index) => {
                        const StatusIcon = statusIcons[order.status as keyof typeof statusIcons];
                        return (
                          <div 
                            key={order.id} 
                            className="group relative overflow-hidden bg-white/80 backdrop-blur-sm rounded-xl shadow-sm hover:shadow-md border border-gray-100 hover:border-blue-200 transition-all duration-300"
                            style={{ animationDelay: `${index * 100}ms` }}
                          >
                            <div className="absolute inset-0 bg-gradient-to-br from-blue-50/0 to-indigo-50/0 group-hover:from-blue-50/20 group-hover:to-indigo-50/20 transition-all duration-500"></div>
                            
                            <div className="relative p-4">
                              {/* Header */}
                              <div className="flex items-start justify-between mb-3">
                                <div className="flex items-center space-x-3 flex-1 min-w-0">
                                  <div className={`h-10 w-10 rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm group-hover:scale-110 transition-transform duration-300 ${
                                    order.type === 'test' 
                                      ? 'bg-gradient-to-br from-blue-100 to-blue-200' 
                                      : 'bg-gradient-to-br from-red-100 to-red-200'
                                  }`}>
                                    {order.type === 'test' ? (
                                      <BeakerIcon className="h-5 w-5 text-blue-600" />
                                    ) : (
                                      <HeartIcon className="h-5 w-5 text-red-600" />
                                    )}
                                  </div>
                                  <div className="flex-1 min-w-0">
                                    <h3 className="text-base font-bold text-gray-900 truncate mb-1">
                                      {order.test_type || `${order.type === 'test' ? 'Lab Test' : 'Blood Service'}`}
                                    </h3>
                                    <p className="text-sm text-gray-500 font-medium">Order #{order.id}</p>
                                  </div>
                                </div>
                                <div className="text-right flex-shrink-0 ml-3">
                                  <div className="text-lg font-bold text-gray-900 mb-1">
                                    {formatCurrency(order.total_amount)}
                                  </div>
                                  <div className={`inline-flex items-center px-2 py-1 rounded-lg text-xs font-semibold ${
                                    order.payment_status === 'paid' ? 'bg-green-100 text-green-800' :
                                    order.payment_status === 'failed' ? 'bg-red-100 text-red-800' :
                                    'bg-yellow-100 text-yellow-800'
                                  }`}>
                                    <CreditCardIcon className="h-3 w-3 mr-1" />
                                    {order.payment_status}
                                  </div>
                                </div>
                              </div>

                              {/* Status */}
                              <div className="mb-3">
                                <span className={`inline-flex items-center px-2.5 py-1.5 rounded-lg text-sm font-bold border shadow-sm ${statusColors[order.status as keyof typeof statusColors]}`}>
                                  <StatusIcon className="w-3 h-3 mr-1.5" />
                                  {order.status.replace('_', ' ').toUpperCase()}
                                </span>
                              </div>

                              {/* Details */}
                              <div className="space-y-2 text-sm text-gray-600 mb-4">
                                <div className="font-medium text-gray-900">{order.facility_name}</div>
                                <div className="flex items-center space-x-2">
                                  <CalendarDaysIcon className="h-4 w-4 text-gray-400" />
                                  <span>Created: {formatDate(order.created_at)}</span>
                                </div>
                                {order.scheduled_date && (
                                  <div className="flex items-center space-x-2 text-blue-600">
                                    <ClockIcon className="h-4 w-4" />
                                    <span className="font-medium">Scheduled: {formatDate(order.scheduled_date)}</span>
                                  </div>
                                )}
                              </div>

                              {/* Actions */}
                              <div className="flex items-center justify-between pt-3 border-t border-gray-100">
                                <div className="flex items-center space-x-2">
                                  {order.results_ready && order.results_url && (
                                    <Link href={`/orders/${order.id}/results`} className="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                                      <DocumentArrowDownIcon className="h-4 w-4" />
                                    </Link>
                                  )}
                                </div>
                                <Link href={`/orders/${order.id}`} className="px-4 py-2 text-sm font-semibold text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200 border border-blue-200 hover:border-blue-300">
                                  <EyeIcon className="h-4 w-4 mr-1.5 inline" />
                                  View Details
                                </Link>
                              </div>
                            </div>
                          </div>
                        );
                      })}
                    </div>
                  </div>
                </div>
              )}
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}