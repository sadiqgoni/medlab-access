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

  if (loading) {
    return (
      <div className="flex items-center justify-center min-h-96">
        <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
      </div>
    );
  }

  if (error) {
    return (
      <div className="bg-red-50 border border-red-200 rounded-lg p-4">
        <div className="text-red-700">Error loading orders: {error}</div>
      </div>
    );
  }

  return (
    <div className="space-y-6">
      {/* Header */}
      <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <h1 className="text-2xl font-bold text-gray-900">My Orders</h1>
          <p className="text-gray-600">Track and manage your medical orders</p>
        </div>
        <Link
          href="/orders/create"
          className="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
        >
          <PlusIcon className="w-5 h-5 mr-2" />
          New Order
        </Link>
      </div>

      {/* Filters */}
      <div className="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
        <div className="flex flex-col lg:flex-row gap-4">
          {/* Search */}
          <div className="flex-1">
            <div className="relative">
              <MagnifyingGlassIcon className="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" />
              <input
                type="text"
                placeholder="Search orders..."
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
                className="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              />
            </div>
          </div>
          
          {/* Status Filter */}
          <div className="flex items-center space-x-2">
            <FunnelIcon className="h-5 w-5 text-gray-400" />
            <select
              value={statusFilter}
              onChange={(e) => setStatusFilter(e.target.value)}
              className="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            >
              <option value="all">All Status</option>
              <option value="pending">Pending</option>
              <option value="confirmed">Confirmed</option>
              <option value="in_progress">In Progress</option>
              <option value="completed">Completed</option>
              <option value="cancelled">Cancelled</option>
            </select>
          </div>

          {/* Type Filter */}
          <select
            value={typeFilter}
            onChange={(e) => setTypeFilter(e.target.value)}
            className="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          >
            <option value="all">All Types</option>
            <option value="test">Lab Tests</option>
            <option value="blood">Blood Services</option>
          </select>
        </div>
      </div>

      {/* Orders List */}
      {filteredOrders.length === 0 ? (
        <div className="bg-white rounded-lg border border-gray-200 p-12 text-center">
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
            className="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
          >
            <PlusIcon className="w-5 h-5 mr-2" />
            Place Your First Order
          </Link>
        </div>
      ) : (
        <div className="bg-white rounded-lg border border-gray-200 overflow-hidden">
          <div className="divide-y divide-gray-200">
            {filteredOrders.map((order) => {
              const StatusIcon = statusIcons[order.status];
              return (
                <div key={order.id} className="p-6 hover:bg-gray-50 transition-colors">
                  <div className="flex items-center justify-between">
                    <div className="flex items-center space-x-4">
                      {/* Order Icon */}
                      <div className={`h-10 w-10 rounded-full flex items-center justify-center ${
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
                        <div className="flex items-center space-x-2">
                          <h3 className="text-lg font-medium text-gray-900">
                            {order.test_type || `${order.type === 'test' ? 'Lab Test' : 'Blood Service'}`}
                          </h3>
                          <span className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${statusColors[order.status]}`}>
                            <StatusIcon className="w-3 h-3 mr-1" />
                            {order.status.replace('_', ' ')}
                          </span>
                        </div>
                        <div className="mt-1 flex items-center space-x-4 text-sm text-gray-600">
                          <span>Order #{order.id}</span>
                          <span>•</span>
                          <span>{order.facility_name}</span>
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
                    <div className="flex items-center space-x-3">
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
      )}
    </div>
  );
}