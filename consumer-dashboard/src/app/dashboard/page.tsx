"use client"

import type React from "react"
import { useEffect, useState } from "react"
import Link from "next/link"
import { 
  ClockIcon, 
  CheckCircleIcon,
  BeakerIcon,
  HeartIcon,
  UserIcon,
  PlusIcon,
  BoltIcon,
  ChevronDownIcon,
  ClipboardDocumentListIcon,
  DocumentCheckIcon,
  CalendarDaysIcon,
} from "@heroicons/react/24/outline"
import { useStore } from "@/store/useStore"
import { getGreeting } from "@/lib/utils"
import StatsCard from "@/components/StatsCard"

interface QuickAction {
  label: string
  href: string
  icon: React.ComponentType<any>
  color: string
}

const quickActions: QuickAction[] = [
  {
    label: "Book Lab Test",
    href: "/orders/create?type=test",
    icon: BeakerIcon,
    color: "text-blue-500",
  },
  {
    label: "Blood Services",
    href: "/orders/create?type=blood",
    icon: HeartIcon,
    color: "text-red-500",
  },
  {
    label: "Update Profile",
    href: "/profile",
    icon: UserIcon,
    color: "text-gray-500",
  },
]

export default function DashboardPage() {
  const { user, stats, recentOrders, loading, error, fetchDashboardData } = useStore()
  const [quickActionsOpen, setQuickActionsOpen] = useState(false)

  useEffect(() => {
    fetchDashboardData()
  }, [fetchDashboardData])

  if (loading) {
    return (
      <div className="flex items-center justify-center min-h-96 px-4">
        <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
      </div>
    )
  }

  if (error) {
    return (
      <div className="bg-red-50 border border-red-200 rounded-lg p-4 mx-4">
        <div className="text-red-700 text-sm">Error loading dashboard: {error}</div>
      </div>
    )
  }

  return (
    <div className="space-y-4 sm:space-y-6 lg:space-y-8 px-3 sm:px-4 lg:px-6">
      {/* Header - Horizontal Layout */}
      <div className="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
        <div>
          <h1 className="font-bold text-2xl lg:text-3xl text-gray-900 leading-tight">
            Good {getGreeting()}, {user?.name?.split(" ")[0] || "User"}!
          </h1>
          <p className="text-gray-600 mt-1 text-sm lg:text-base">Here's what's happening with your health today</p>
        </div>
        
        {/* Action Buttons - Horizontal on desktop */}
        <div className="flex items-center space-x-3">
          {/* Primary Action Button */}
          <Link
            href="/orders/create"
            className="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-700 to-blue-800 border border-transparent rounded-lg font-semibold text-sm text-white hover:from-blue-800 hover:to-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 transform hover:scale-105 transition-all duration-200 shadow-lg"
          >
            <PlusIcon className="w-5 h-5 mr-2" />
            New Order
          </Link>
          
          {/* Quick Actions Dropdown */}
          <div className="relative">
            <button 
              onClick={() => setQuickActionsOpen(!quickActionsOpen)}
              className="inline-flex items-center justify-center px-4 py-3 bg-white border border-gray-300 rounded-lg font-medium text-sm text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200"
            >
              <BoltIcon className="w-4 h-4 mr-2" />
              Quick Actions
              <ChevronDownIcon className="w-4 h-4 ml-2" />
            </button>
            
            {quickActionsOpen && (
              <>
                <div className="fixed inset-0 z-10" onClick={() => setQuickActionsOpen(false)} />
                <div className="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 z-20">
                  <div className="py-2">
                    {quickActions.map((action) => (
                      <Link
                        key={action.label}
                        href={action.href}
                        className="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 active:bg-gray-100"
                        onClick={() => setQuickActionsOpen(false)}
                      >
                        <action.icon className={`w-5 h-5 mr-3 ${action.color}`} />
                        {action.label}
                      </Link>
                    ))}
                  </div>
                </div>
              </>
            )}
          </div>
        </div>
      </div>

      {/* Health Status Banner - Redesigned Layout */}
      <div className="bg-gradient-to-br from-blue-50 via-blue-100 to-indigo-50 rounded-2xl shadow-sm overflow-hidden relative">
        <div className="absolute inset-0 bg-gradient-to-r from-blue-600/10 to-indigo-600/10"></div>
        <div className="relative px-6 lg:px-8 py-6">
          <div className="grid lg:grid-cols-[1fr_auto] gap-6 items-start">
            {/* Left Content */}
          <div className="space-y-4">
            {/* Profile Section */}
              <div className="flex items-start space-x-4">
                <div className="h-12 w-12 rounded-full bg-gradient-to-r from-blue-600 to-blue-700 flex items-center justify-center shadow-lg flex-shrink-0">
                  <span className="text-white text-xl font-bold">{user?.name?.charAt(0) || "U"}</span>
              </div>
              <div className="min-w-0 flex-1">
                  <h2 className="text-xl lg:text-2xl font-bold text-gray-900 leading-tight">
                  Overview of Your Health Services
                </h2>
                  <p className="text-gray-600 text-sm lg:text-base mt-1">
                  Stay on top of your health with our comprehensive medical services
                </p>
              </div>
            </div>
            
            {/* Active Orders Alert */}
            {stats && stats.activeOrders > 0 && (
                <div className="p-4 bg-white/80 rounded-lg backdrop-blur-sm border border-white/20">
                <div className="flex items-start space-x-3">
                  <div className="flex-shrink-0">
                      <div className="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                        <ClockIcon className="h-4 w-4 text-blue-600" />
                      </div>
                  </div>
                  <div className="min-w-0 flex-1">
                      <p className="text-sm font-medium text-gray-900 leading-tight">
                        You have {stats.activeOrders} active {stats.activeOrders === 1 ? "order" : "orders"} in progress
                    </p>
                    <p className="text-xs text-gray-600 mt-1">Track your orders for real-time updates</p>
                  </div>
                  <div className="flex-shrink-0">
                      <Link
                        href="/orders"
                        className="text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors whitespace-nowrap"
                      >
                      View →
                    </Link>
                  </div>
                </div>
              </div>
            )}
            </div>

            {/* Right Stats Cards */}
            <div className="grid grid-cols-2 lg:grid-cols-1 gap-3 lg:gap-4 lg:w-48">
              <div className="text-center p-4 bg-white/80 rounded-xl backdrop-blur-sm border border-white/20">
                <div className="text-2xl lg:text-3xl font-bold text-blue-600">{stats?.totalOrders || 0}</div>
                <div className="text-xs text-gray-600 uppercase tracking-wide mt-1">Total Orders</div>
              </div>
              <div className="text-center p-4 bg-white/80 rounded-xl backdrop-blur-sm border border-white/20">
                <div className="text-2xl lg:text-3xl font-bold text-green-600">{stats?.completedOrders || 0}</div>
                <div className="text-xs text-gray-600 uppercase tracking-wide mt-1">Completed</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Quick Stats Grid - Mobile Responsive */}
      <div className="grid grid-cols-1 gap-3 sm:gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <StatsCard
          title="Active Orders"
          value={stats?.activeOrders || 0}
          icon={ClipboardDocumentListIcon}
          color="blue"
          description="Track progress"
          href="/orders"
          trend={stats?.activeOrders ? { value: stats.activeOrders, isPositive: true } : undefined}
        />
        
        <StatsCard
          title="Results Ready"
          value={stats?.resultsReadyOrders || 0}
          icon={DocumentCheckIcon}
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
          icon={CalendarDaysIcon}
          color="red"
          description="All services"
        />
      </div>

      {/* Recent Orders - Mobile Optimized */}
      {recentOrders && recentOrders.length > 0 && (
        <div className="bg-white shadow-sm sm:shadow rounded-lg sm:rounded-xl overflow-hidden">
          <div className="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 bg-gray-50 sm:bg-white">
            <div className="flex items-center justify-between">
              <h3 className="text-base sm:text-lg font-medium text-gray-900">Recent Orders</h3>
              <Link 
                href="/orders" 
                className="text-xs sm:text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors"
              >
                View all →
              </Link>
            </div>
          </div>
          <div className="divide-y divide-gray-100">
            {recentOrders.slice(0, 5).map((order) => (
              <div
                key={order.id}
                className="px-4 sm:px-6 py-3 sm:py-4 hover:bg-gray-50 active:bg-gray-100 transition-colors"
              >
                <div className="flex items-center space-x-3">
                  <div
                    className={`h-8 w-8 sm:h-10 sm:w-10 rounded-full flex items-center justify-center flex-shrink-0 ${
                      order.type === "test" ? "bg-blue-100" : "bg-red-100"
                    }`}
                  >
                    {order.type === "test" ? (
                      <BeakerIcon className="h-4 w-4 sm:h-5 sm:w-5 text-blue-600" />
                    ) : (
                      <HeartIcon className="h-4 w-4 sm:h-5 sm:w-5 text-red-600" />
                    )}
                  </div>
                  
                  <div className="flex-1 min-w-0">
                    <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-1 sm:space-y-0">
                      <div className="min-w-0 flex-1">
                        <p className="text-sm sm:text-base font-medium text-gray-900 truncate">
                          {order.test_type || `${order.type === "test" ? "Lab Test" : "Blood Service"}`}
                        </p>
                        <p className="text-xs sm:text-sm text-gray-500 truncate">
                          Order #{order.id} • {order.facility_name}
                        </p>
                      </div>
                      <div className="flex-shrink-0">
                        <span
                          className={`inline-flex px-2 sm:px-3 py-1 text-xs font-semibold rounded-full capitalize whitespace-nowrap ${
                            order.status === "completed"
                              ? "bg-green-100 text-green-800"
                              : order.status === "in_progress"
                                ? "bg-blue-100 text-blue-800"
                                : order.status === "pending"
                                  ? "bg-yellow-100 text-yellow-800"
                                  : "bg-gray-100 text-gray-800"
                          }`}
                        >
                          {order.status.replace("_", " ")}
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      )}
    </div>
  )
}


