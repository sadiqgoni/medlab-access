'use client';

import React, { useEffect, useState } from 'react';
import Link from 'next/link';
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
} from '@heroicons/react/24/outline';
import { useStore } from '@/store/useStore';
import { formatDate, formatCurrency } from '@/lib/utils';
import { Order } from '@/types';

const statusColors = {
  pending: 'bg-yellow-100 text-yellow-800',
  confirmed: 'bg-blue-100 text-blue-800',
  in_progress: 'bg-blue-100 text-blue-800',
  completed: 'bg-green-100 text-green-800',
  cancelled: 'bg-red-100 text-red-800',
};

const statusIcons = {
  pending: ClockIcon,
  confirmed: ClockIcon,
  in_progress: ClockIcon,
  completed: CheckCircleIcon,
  cancelled: ClockIcon,
};

export default function OrdersPage() {
  const { orders, loading, error, fetchOrders } = useStore();
  const [searchTerm, setSearchTerm] = useState('');
  const [statusFilter, setStatusFilter] = useState<string>('all');
  const [typeFilter, setTypeFilter] = useState<string>('all');
  const [showFilters, setShowFilters] = useState(false);

  useEffect(() => {
    fetchOrders();
  }, [fetchOrders]);

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
      <div className="flex items-center justify-center min-h-96 px-4">
        <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
      </div>
    );
  }

  if (error) {
    return (
      <div className="bg-red-50 border border-red-200 rounded-lg p-4 mx-4">
        <div className="text-red-700 text-sm">Error loading orders: {error}</div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-gray-50">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
        <div className="space-y-6">
          {/* Header */}
          <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div className="text-center sm:text-left">
              <h1 className="text-2xl sm:text-3xl font-bold text-gray-900">My Orders</h1>
              <p className="text-gray-600 mt-1">Track and manage your medical orders</p>
            </div>
            <Link
              href="/orders/create"
              className="inline-flex items-center justify-center px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium text-sm sm:text-base"
            >
              <PlusIcon className="w-5 h-5 mr-2" />
              New Order
            </Link>
          </div>

          {/* Search Bar */}
          <div className="relative">
            <MagnifyingGlassIcon className="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" />
            <input
              type="text"
              placeholder="Search orders..."
              value={searchTerm}
              onChange={(e) => setSearchTerm(e.target.value)}
              className="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            />
          </div>

          {/* Filters */}
          <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            {/* Mobile Filter Toggle */}
            <button
              onClick={() => setShowFilters(!showFilters)}
              className="sm:hidden inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <FunnelIcon className="w-4 h-4 mr-2" />
              Filters
              {activeFiltersCount > 0 && (
                <span className="ml-2 bg-blue-600 text-white text-xs rounded-full px-2 py-0.5">
                  {activeFiltersCount}
                </span>
              )}
              <ChevronDownIcon className={`w-4 h-4 ml-2 transform transition-transform ${showFilters ? 'rotate-180' : ''}`} />
            </button>

            {/* Desktop Filters */}
            <div className="hidden sm:flex items-center space-x-3">
              <FunnelIcon className="h-5 w-5 text-gray-400" />
              <select
                value={statusFilter}
                onChange={(e) => setStatusFilter(e.target.value)}
                className="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
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
                className="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              >
                <option value="all">All Types</option>
                <option value="test">Lab Tests</option>
                <option value="blood">Blood Services</option>
              </select>
            </div>

            <div className="hidden sm:block text-sm text-gray-600">
              {filteredOrders.length} of {orders.length} orders
            </div>
          </div>

          {/* Mobile Filters Dropdown */}
          {showFilters && (
            <div className="sm:hidden bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
              <div className="flex items-center justify-between mb-4">
                <h3 className="font-medium text-gray-900">Filter Orders</h3>
                <button
                  onClick={() => setShowFilters(false)}
                  className="p-1 text-gray-400 hover:text-gray-600"
                >
                  <XMarkIcon className="w-5 h-5" />
                </button>
              </div>
              
              <div className="space-y-4">
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">Status</label>
                  <select
                    value={statusFilter}
                    onChange={(e) => setStatusFilter(e.target.value)}
                    className="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
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
                  <label className="block text-sm font-medium text-gray-700 mb-2">Type</label>
                  <select
                    value={typeFilter}
                    onChange={(e) => setTypeFilter(e.target.value)}
                    className="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
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
                    className="w-full px-4 py-2 text-sm text-gray-600 hover:text-gray-800 border border-gray-300 rounded-lg hover:bg-gray-50"
                  >
                    Clear All Filters
                  </button>
                )}
              </div>
            </div>
          )}

          {/* Results Count - Mobile */}
          <div className="sm:hidden text-sm text-gray-600 text-center">
            {filteredOrders.length} of {orders.length} orders
          </div>

          {/* Orders List */}
          {filteredOrders.length === 0 ? (
            <div className="bg-white rounded-lg border border-gray-200 p-8 sm:p-12 text-center">
              <div className="h-12 w-12 mx-auto mb-4 text-gray-400">
                <BeakerIcon className="h-full w-full" />
              </div>
              <h3 className="text-lg font-medium text-gray-900 mb-2">No orders found</h3>
              <p className="text-gray-600 mb-6">
                {orders.length === 0 
                  ? "You haven't placed any orders yet." 
                  : "No orders match your search criteria."
                }
              </p>
              <Link
                href="/orders/create"
                className="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium"
              >
                <PlusIcon className="w-5 h-5 mr-2" />
                Place Your First Order
              </Link>
            </div>
          ) : (
            <div className="space-y-3 sm:space-y-0">
              {/* Desktop: Table-like layout */}
              <div className="hidden lg:block bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div className="divide-y divide-gray-100">
                  {filteredOrders.map((order) => {
                    const StatusIcon = statusIcons[order.status];
                    return (
                      <div key={order.id} className="p-6 hover:bg-gray-50 transition-colors">
                        <div className="flex items-center justify-between">
                          <div className="flex items-center space-x-4 flex-1 min-w-0">
                            {/* Order Icon */}
                            <div className={`h-10 w-10 rounded-full flex items-center justify-center flex-shrink-0 ${
                              order.type === 'test' ? 'bg-blue-100' : 'bg-red-100'
                            }`}>
                              {order.type === 'test' ? (
                                <BeakerIcon className="h-5 w-5 text-blue-600" />
                              ) : (
                                <HeartIcon className="h-5 w-5 text-red-600" />
                              )}
                            </div>

                            {/* Order Details */}
                            <div className="flex-1 min-w-0">
                              <div className="flex items-center space-x-3 mb-1">
                                <h3 className="text-lg font-medium text-gray-900 truncate">
                                  {order.test_type || `${order.type === 'test' ? 'Lab Test' : 'Blood Service'}`}
                                </h3>
                                <span className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium flex-shrink-0 ${statusColors[order.status]}`}>
                                  <StatusIcon className="w-3 h-3 mr-1" />
                                  {order.status.replace('_', ' ')}
                                </span>
                              </div>
                              <div className="flex items-center space-x-4 text-sm text-gray-600">
                                <span>Order #{order.id}</span>
                                <span>•</span>
                                <span className="truncate">{order.facility_name}</span>
                                <span>•</span>
                                <span>{formatDate(order.created_at)}</span>
                              </div>
                              {order.scheduled_date && (
                                <div className="mt-1 text-sm text-gray-600">
                                  Scheduled: {formatDate(order.scheduled_date)}
                                </div>
                              )}
                            </div>
                          </div>

                          {/* Actions */}
                          <div className="flex items-center space-x-4 flex-shrink-0">
                            <div className="text-right">
                              <div className="text-lg font-semibold text-gray-900">
                                {formatCurrency(order.total_amount)}
                              </div>
                              <div className={`text-xs ${
                                order.payment_status === 'paid' ? 'text-green-600' :
                                order.payment_status === 'failed' ? 'text-red-600' :
                                'text-yellow-600'
                              }`}>
                                {order.payment_status}
                              </div>
                            </div>

                            <div className="flex items-center space-x-2">
                              {order.results_ready && order.results_url && (
                                <button className="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                  <DocumentArrowDownIcon className="h-5 w-5" />
                                </button>
                              )}
                              <Link
                                href={`/orders/${order.id}`}
                                className="px-3 py-1.5 text-sm font-medium text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                              >
                                View Details
                              </Link>
                            </div>
                          </div>
                        </div>
                      </div>
                    );
                  })}
                </div>
              </div>

              {/* Mobile & Tablet: Card layout */}
              <div className="lg:hidden space-y-3">
                {filteredOrders.map((order) => {
                  const StatusIcon = statusIcons[order.status];
                  return (
                    <div key={order.id} className="bg-white rounded-lg border border-gray-200 p-4 hover:shadow-md transition-shadow">
                      {/* Header */}
                      <div className="flex items-start justify-between mb-3">
                        <div className="flex items-center space-x-3 flex-1 min-w-0">
                          <div className={`h-10 w-10 rounded-full flex items-center justify-center flex-shrink-0 ${
                            order.type === 'test' ? 'bg-blue-100' : 'bg-red-100'
                          }`}>
                            {order.type === 'test' ? (
                              <BeakerIcon className="h-5 w-5 text-blue-600" />
                            ) : (
                              <HeartIcon className="h-5 w-5 text-red-600" />
                            )}
                          </div>
                          <div className="flex-1 min-w-0">
                            <h3 className="text-base font-medium text-gray-900 truncate">
                              {order.test_type || `${order.type === 'test' ? 'Lab Test' : 'Blood Service'}`}
                            </h3>
                            <p className="text-sm text-gray-500">Order #{order.id}</p>
                          </div>
                        </div>
                        <div className="text-right flex-shrink-0 ml-3">
                          <div className="text-lg font-semibold text-gray-900">
                            {formatCurrency(order.total_amount)}
                          </div>
                          <div className={`text-xs ${
                            order.payment_status === 'paid' ? 'text-green-600' :
                            order.payment_status === 'failed' ? 'text-red-600' :
                            'text-yellow-600'
                          }`}>
                            {order.payment_status}
                          </div>
                        </div>
                      </div>

                      {/* Status */}
                      <div className="mb-3">
                        <span className={`inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium ${statusColors[order.status]}`}>
                          <StatusIcon className="w-3 h-3 mr-1" />
                          {order.status.replace('_', ' ')}
                        </span>
                      </div>

                      {/* Details */}
                      <div className="space-y-1 text-sm text-gray-600 mb-4">
                        <div className="truncate">{order.facility_name}</div>
                        <div>Created: {formatDate(order.created_at)}</div>
                        {order.scheduled_date && (
                          <div>Scheduled: {formatDate(order.scheduled_date)}</div>
                        )}
                      </div>

                      {/* Actions */}
                      <div className="flex items-center justify-between pt-3 border-t border-gray-100">
                        <div className="flex items-center space-x-2">
                          {order.results_ready && order.results_url && (
                            <button className="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                              <DocumentArrowDownIcon className="h-4 w-4" />
                            </button>
                          )}
                        </div>
                        <Link
                          href={`/orders/${order.id}`}
                          className="px-4 py-2 text-sm font-medium text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                        >
                          View Details
                        </Link>
                      </div>
                    </div>
                  );
                })}
              </div>
            </div>
          )}
        </div>
      </div>
    </div>
  );
}