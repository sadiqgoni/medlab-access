'use client';

import React, { useEffect, useState } from 'react';
import Link from 'next/link';
import { 
  ClockIcon, 
  DocumentTextIcon, 
  CheckCircleIcon,
  BeakerIcon,
  HeartIcon,
  UserIcon,
  PlusIcon,
  BoltIcon,
  ChevronDownIcon,
} from '@heroicons/react/24/outline';
import { useStore } from '@/store/useStore';
import { getGreeting } from '@/lib/utils';
import StatsCard from '@/components/StatsCard';

interface QuickAction {
  label: string;
  href: string;
  icon: React.ComponentType<any>;
  color: string;
}

const quickActions: QuickAction[] = [
  {
    label: 'Book Lab Test',
    href: '/orders/create?type=test',
    icon: BeakerIcon,
    color: 'text-blue-500',
  },
  {
    label: 'Blood Services',
    href: '/orders/create?type=blood',
    icon: HeartIcon,
    color: 'text-red-500',
  },
  {
    label: 'Update Profile',
    href: '/profile',
    icon: UserIcon,
    color: 'text-gray-500',
  },
];

export default function DashboardPage() {
  const { user, stats, recentOrders, loading, error, fetchDashboardData } = useStore();
  const [quickActionsOpen, setQuickActionsOpen] = useState(false);

  useEffect(() => {
    fetchDashboardData();
  }, [fetchDashboardData]);

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
        <div className="text-red-700">Error loading dashboard: {error}</div>
      </div>
    );
  }

  return (
    <div className="space-y-8">
      {/* Header */}
      <div className="flex flex-col space-y-4 sm:flex-row sm:items-center sm:justify-between sm:space-y-0">
        <div className="flex-1 min-w-0">
          <h2 className="font-bold text-xl sm:text-2xl lg:text-3xl text-gray-900 leading-tight">
            Good {getGreeting()}, {user?.name?.split(' ')[0] || 'User'}!
          </h2>
          <p className="text-gray-600 mt-1 text-sm sm:text-base lg:text-lg">
            Here's what's happening with your health today
          </p>
        </div>
        
        <div className="flex flex-col space-y-2 sm:flex-row sm:items-center sm:space-y-0 sm:space-x-3">
          {/* Quick Actions Dropdown */}
          <div className="relative">
            <button 
              onClick={() => setQuickActionsOpen(!quickActionsOpen)}
              className="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-medium text-sm text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200"
            >
              <BoltIcon className="w-4 h-4 mr-2" />
              Quick Actions
              <ChevronDownIcon className="w-4 h-4 ml-2" />
            </button>
            
            {quickActionsOpen && (
              <>
                <div 
                  className="fixed inset-0 z-10" 
                  onClick={() => setQuickActionsOpen(false)}
                />
                <div className="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 z-20">
                  <div className="py-2">
                    {quickActions.map((action) => (
                      <Link
                        key={action.label}
                        href={action.href}
                        className="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                        onClick={() => setQuickActionsOpen(false)}
                      >
                        <action.icon className={`w-4 h-4 mr-3 ${action.color}`} />
                        {action.label}
                      </Link>
                    ))}
                  </div>
                </div>
              </>
            )}
          </div>
          
          <Link
            href="/orders/create"
            className="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 bg-gradient-to-r from-blue-700 to-blue-800 border border-transparent rounded-lg font-semibold text-sm text-white hover:from-blue-800 hover:to-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 transform hover:scale-105 transition-all duration-200 shadow-lg"
          >
            <PlusIcon className="w-5 h-5 mr-2" />
            New Order
          </Link>
        </div>
      </div>

      {/* Health Status Banner */}
      <div className="bg-gradient-to-br from-blue-50 via-blue-100 to-indigo-50 rounded-2xl shadow-sm overflow-hidden relative">
        <div className="absolute inset-0 bg-gradient-to-r from-blue-600/10 to-indigo-600/10"></div>
        <div className="relative px-4 sm:px-6 lg:px-8 py-4 sm:py-6 md:flex md:items-center md:justify-between">
          <div className="max-w-2xl">
            <div className="flex items-center mb-3">
              <div className="h-10 w-10 sm:h-12 sm:w-12 rounded-full bg-gradient-to-r from-blue-600 to-blue-700 flex items-center justify-center mr-3 sm:mr-4 shadow-lg">
                <span className="text-white text-xl font-bold">
                  {user?.name?.charAt(0) || 'U'}
                </span>
              </div>
              <div>
                <h2 className="text-xl sm:text-2xl font-bold text-gray-900">Your Health Dashboard</h2>
                <p className="text-gray-600">
                  Stay on top of your health with our comprehensive medical services
                </p>
              </div>
            </div>
            
            {stats && stats.activeOrders > 0 && (
              <div className="flex items-center mt-4 p-3 bg-white/70 rounded-lg backdrop-blur-sm">
                <div className="flex-shrink-0">
                  <div className="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                    <ClockIcon className="h-4 w-4 text-blue-600" />
                  </div>
                </div>
                <div className="ml-3">
                  <p className="text-sm font-medium text-gray-900">
                    You have {stats.activeOrders} active {stats.activeOrders === 1 ? 'order' : 'orders'} in progress
                  </p>
                  <p className="text-xs text-gray-600">Track your orders for real-time updates</p>
                </div>
                <div className="ml-auto">
                  <Link href="/orders" className="text-sm font-medium text-blue-600 hover:text-blue-700">
                    View Orders →
                  </Link>
                </div>
              </div>
            )}
          </div>
          
          <div className="mt-6 md:mt-0 md:ml-8">
            <div className="grid grid-cols-2 gap-4">
              <div className="text-center p-4 bg-white/70 rounded-xl backdrop-blur-sm">
                <div className="text-2xl font-bold text-blue-600">{stats?.totalOrders || 0}</div>
                <div className="text-xs text-gray-600 uppercase tracking-wide">Total Orders</div>
              </div>
              <div className="text-center p-4 bg-white/70 rounded-xl backdrop-blur-sm">
                <div className="text-2xl font-bold text-green-600">{stats?.completedOrders || 0}</div>
                <div className="text-xs text-gray-600 uppercase tracking-wide">Completed</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Quick Stats Grid */}
      <div className="grid grid-cols-1 gap-4 sm:gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <StatsCard
          title="Active Orders"
          value={stats?.activeOrders || 0}
          icon={ClockIcon}
          color="blue"
          description="Track progress"
          href="/orders"
          trend={stats?.activeOrders ? { value: stats.activeOrders, isPositive: true } : undefined}
        />
        
        <StatsCard
          title="Results Ready"
          value={stats?.resultsReadyOrders || 0}
          icon={DocumentTextIcon}
          color="purple"
          description="Download results"
          href="/orders"
          badge={stats?.resultsReadyOrders ? "New" : undefined}
        />
        
        <StatsCard
          title="Completed"
          value={stats?.completedOrders || 0}
          icon={CheckCircleIcon}
          color="green"
          description="View history"
          href="/orders"
        />
        
        <StatsCard
          title="This Month"
          value={stats?.totalOrders || 0}
          icon={BeakerIcon}
          color="red"
          description="All services"
        />
      </div>

      {/* Recent Orders */}
      {recentOrders && recentOrders.length > 0 && (
        <div className="bg-white shadow rounded-xl">
          <div className="px-6 py-4 border-b border-gray-200">
            <div className="flex items-center justify-between">
              <h3 className="text-lg font-medium text-gray-900">Recent Orders</h3>
              <Link 
                href="/orders" 
                className="text-sm font-medium text-blue-600 hover:text-blue-700"
              >
                View all →
              </Link>
            </div>
          </div>
          <div className="divide-y divide-gray-200">
            {recentOrders.slice(0, 5).map((order) => (
              <div key={order.id} className="px-6 py-4 hover:bg-gray-50">
                <div className="flex items-center justify-between">
                  <div className="flex-1 min-w-0">
                    <div className="flex items-center">
                      <div className={`h-8 w-8 rounded-full flex items-center justify-center mr-3 ${
                        order.type === 'test' ? 'bg-blue-100' : 'bg-red-100'
                      }`}>
                        {order.type === 'test' ? (
                          <BeakerIcon className={`h-4 w-4 ${
                            order.type === 'test' ? 'text-blue-600' : 'text-red-600'
                          }`} />
                        ) : (
                          <HeartIcon className="h-4 w-4 text-red-600" />
                        )}
                      </div>
                      <div>
                        <p className="text-sm font-medium text-gray-900">
                          {order.test_type || `${order.type === 'test' ? 'Lab Test' : 'Blood Service'}`}
                        </p>
                        <p className="text-xs text-gray-500">
                          Order #{order.id} • {order.facility_name}
                        </p>
                      </div>
                    </div>
                  </div>
                  <div className="text-right">
                    <span className={`inline-flex px-2 py-1 text-xs font-medium rounded-full ${
                      order.status === 'completed' ? 'bg-green-100 text-green-800' :
                      order.status === 'in_progress' ? 'bg-blue-100 text-blue-800' :
                      order.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                      'bg-gray-100 text-gray-800'
                    }`}>
                      {order.status.replace('_', ' ')}
                    </span>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      )}
    </div>
  );
}