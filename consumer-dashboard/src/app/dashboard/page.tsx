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
  ArrowTrendingUpIcon,
  SparklesIcon,
  ChartBarIcon,
  EyeIcon,
} from "@heroicons/react/24/outline"
import { 
  CheckCircleIcon as CheckCircleIconSolid,
  ClockIcon as ClockIconSolid,
  ExclamationTriangleIcon as ExclamationTriangleIconSolid,
} from "@heroicons/react/24/solid"
import { useStore } from "@/store/useStore"
import { getGreeting } from "@/lib/utils"
import StatsCard from "@/components/StatsCard"

interface QuickAction {
  label: string
  href: string
  icon: React.ComponentType<any>
  color: string
  gradient: string
}

const quickActions: QuickAction[] = [
  {
    label: "Book Lab Test",
    href: "/orders/create?type=test",
    icon: BeakerIcon,
    color: "text-blue-600",
    gradient: "from-blue-500 to-blue-600",
  },
  {
    label: "Blood Services",
    href: "/orders/create?type=blood",
    icon: HeartIcon,
    color: "text-red-600",
    gradient: "from-red-500 to-red-600",
  },
  {
    label: "Update Profile",
    href: "/profile",
    icon: UserIcon,
    color: "text-purple-600",
    gradient: "from-purple-500 to-purple-600",
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
      <div className="flex items-center justify-center min-h-64 px-4">
        <div className="relative">
          <div className="animate-spin rounded-full h-12 w-12 border-4 border-blue-100"></div>
          <div className="animate-spin rounded-full h-12 w-12 border-4 border-blue-600 border-t-transparent absolute top-0 left-0"></div>
          <div className="absolute inset-0 flex items-center justify-center">
            <SparklesIcon className="h-5 w-5 text-blue-600 animate-pulse" />
          </div>
        </div>
      </div>
    )
  }

  if (error) {
    return (
      <div className="bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 rounded-xl p-4 mx-4 shadow-sm">
        <div className="flex items-center space-x-3">
          <ExclamationTriangleIconSolid className="h-5 w-5 text-red-500" />
          <div className="text-red-700 font-medium text-sm">Error loading dashboard: {error}</div>
        </div>
      </div>
    )
  }

  const getStatusColor = (status: string) => {
    switch (status) {
      case "completed":
        return "bg-emerald-100 text-emerald-800 border-emerald-200"
      case "in_progress":
        return "bg-blue-100 text-blue-800 border-blue-200"
      case "pending":
        return "bg-amber-100 text-amber-800 border-amber-200"
      default:
        return "bg-gray-100 text-gray-800 border-gray-200"
    }
  }

  return (
    <div className="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/50">
      <div className="space-y-4 px-4 sm:px-6 lg:px-8 py-4 lg:py-6 max-w-7xl mx-auto">
        
        {/* Compact Header */}
        <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
          <div>
            <h1 className="font-bold text-2xl sm:text-3xl text-gray-900 leading-tight tracking-tight">
              Good {getGreeting()}, {user?.name?.split(" ")[0] || "User"}!
            </h1>
            <p className="text-gray-600 text-sm sm:text-base font-medium">
              Your health journey continues today
            </p>
          </div>
          
         {/* Compact Action Buttons */}
         <div className="flex items-center space-x-3 w-full sm:w-auto">
            <Link
              href="/orders/create"
              className="group inline-flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 border border-transparent rounded-xl font-semibold text-sm text-white hover:from-blue-700 hover:via-blue-800 hover:to-indigo-800 focus:outline-none focus:ring-4 focus:ring-blue-500/25 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl w-1/2 sm:w-auto"
            >
              <PlusIcon className="w-4 h-4 mr-2" />
              <span className="hidden sm:inline">New Order</span>
              <span className="sm:hidden">New Order</span>
            </Link>
            
            <div className="relative w-1/2 sm:w-auto">
              <button 
                onClick={() => setQuickActionsOpen(!quickActionsOpen)}
                className="inline-flex items-center justify-center px-3 sm:px-4 py-2.5 sm:py-3 bg-white border border-gray-200 rounded-xl font-semibold text-gray-700 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-4 focus:ring-blue-500/25 transition-all duration-200 shadow-sm hover:shadow-md text-sm w-full"
              >
                <BoltIcon className="w-4 h-4 mr-1 sm:mr-2 text-amber-500" />
                <span className="hidden sm:inline">Quick Actions</span>
                <span className="sm:hidden">Quick Actions</span>
                <ChevronDownIcon className={`w-3 h-3 ml-1 sm:ml-2 transition-transform duration-200 ${quickActionsOpen ? 'rotate-180' : ''}`} />
              </button>
              {quickActionsOpen && (
                <>
                  <div className="fixed inset-0 z-10" onClick={() => setQuickActionsOpen(false)} />
                  <div className="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 z-20 overflow-hidden">
                    <div className="p-1">
                      {quickActions.map((action) => (
                        <Link
                          key={action.label}
                          href={action.href}
                          className="flex items-center px-3 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-all duration-200 group"
                          onClick={() => setQuickActionsOpen(false)}
                        >
                          <div className={`p-2 rounded-lg bg-gradient-to-r ${action.gradient} mr-3 group-hover:scale-110 transition-transform duration-200`}>
                            <action.icon className="w-4 h-4 text-white" />
                          </div>
                          <div>
                            <div className="font-medium text-gray-900 text-sm">{action.label}</div>
                            <div className="text-xs text-gray-500">Quick access</div>
                          </div>
                        </Link>
                      ))}
                    </div>
                  </div>
                </>
              )}
            </div>
          </div>
        </div>

        {/* Compact Health Overview Card */}
        <div className="relative overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 rounded-2xl shadow-xl">
          <div className="absolute inset-0 opacity-10">
            <div className="absolute top-0 left-0 w-48 h-48 bg-white rounded-full -translate-x-24 -translate-y-24 animate-pulse"></div>
            <div className="absolute bottom-0 right-0 w-64 h-64 bg-white rounded-full translate-x-32 translate-y-32 animate-pulse delay-1000"></div>
          </div>
          
          <div className="relative px-4 sm:px-6 py-5 sm:py-6">
            <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
              {/* Left Content */}
              <div className="flex items-start space-x-4">
                <div className="relative">
                  <div className="h-12 w-12 rounded-xl bg-gradient-to-br from-white/20 to-white/10 backdrop-blur-sm flex items-center justify-center shadow-lg border border-white/20">
                    <span className="text-white text-xl font-bold">{user?.name?.charAt(0) || "U"}</span>
                  </div>
                  <div className="absolute -bottom-1 -right-1 h-5 w-5 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                    <CheckCircleIconSolid className="h-2.5 w-2.5 text-white" />
                  </div>
                </div>
                <div className="min-w-0 flex-1">
                  <h2 className="text-lg sm:text-xl font-bold text-white leading-tight">
                    Your Health Dashboard
                  </h2>
                  <p className="text-blue-100 text-sm font-medium">
                    Comprehensive medical services
                  </p>
                </div>
              </div>

              {/* Right Stats - Horizontal Layout */}
              <div className="flex space-x-4">
                <div className="text-center w-1/2 p-3 bg-white/10 backdrop-blur-md rounded-xl border border-white/20 shadow-lg hover:bg-white/15 transition-all duration-300 group min-w-0">
                  <div className="text-2xl font-bold text-white mb-1 group-hover:scale-110 transition-transform duration-300">
                    {stats?.totalOrders || 0}
                  </div>
                  <div className="text-blue-100 text-xs uppercase tracking-wider font-medium">Total Orders</div>
                </div>
                <div className="text-center p-3  w-1/2 bg-white/10 backdrop-blur-md rounded-xl border border-white/20 shadow-lg hover:bg-white/15 transition-all duration-300 group min-w-0">
                  <div className="text-2xl font-bold text-white mb-1 group-hover:scale-110 transition-transform duration-300">
                    {stats?.completedOrders || 0}
                  </div>
                  <div className="text-blue-100 text-xs uppercase tracking-wider font-medium">Completed</div>
                </div>
              </div>
            </div>

            {/* Active Orders Alert - Compact */}
            {stats && stats.activeOrders > 0 && (
              <div className="mt-4 p-3 bg-white/10 backdrop-blur-md rounded-xl border border-white/20 shadow-lg">
                <div className="flex items-center space-x-3">
                  <div className="flex-shrink-0">
                    <div className="h-8 w-8 rounded-lg bg-amber-500/20 flex items-center justify-center">
                      <ClockIconSolid className="h-4 w-4 text-amber-300" />
                    </div>
                  </div>
                  <div className="min-w-0 flex-1">
                    <p className="text-white font-semibold text-sm leading-tight">
                      {stats.activeOrders} Active {stats.activeOrders === 1 ? "Order" : "Orders"}
                    </p>
                    <p className="text-blue-100 text-xs">Track your orders for updates</p>
                  </div>
                  <div className="flex-shrink-0">
                    <Link
                      href="/orders"
                      className="inline-flex items-center px-3 py-1.5 bg-white/20 hover:bg-white/30 text-white font-medium rounded-lg transition-all duration-200 backdrop-blur-sm border border-white/20 text-xs"
                    >
                      <EyeIcon className="h-3 w-3 mr-1" />
                      View
                    </Link>
                  </div>
                </div>
              </div>
            )}
          </div>
        </div>

        {/* Compact Stats Grid */}
        <div className="grid grid-cols-2 gap-3 sm:grid-cols-4">
          <div className="group relative overflow-hidden bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 hover:border-blue-200">
            <div className="absolute inset-0 bg-gradient-to-br from-blue-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div className="relative p-4">
              <div className="flex items-center justify-between mb-3">
                <div className="p-2 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition-colors duration-300">
                  <ClipboardDocumentListIcon className="h-5 w-5 text-blue-600" />
                </div>
                {(stats?.activeOrders || 0) > 0 && (
                  <div className="px-2 py-0.5 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">
                    Active
                  </div>
                )}
              </div>
              <div className="text-xl font-bold text-gray-900 mb-1">{stats?.activeOrders || 0}</div>
              <div className="text-gray-600 font-medium text-sm mb-1">Active Orders</div>
              <div className="text-xs text-gray-500">Track progress</div>
            </div>
          </div>

          <div className="group relative overflow-hidden bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 hover:border-purple-200">
            <div className="absolute inset-0 bg-gradient-to-br from-purple-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div className="relative p-4">
              <div className="flex items-center justify-between mb-3">
                <div className="p-2 bg-purple-100 rounded-lg group-hover:bg-purple-200 transition-colors duration-300">
                  <DocumentCheckIcon className="h-5 w-5 text-purple-600" />
                </div>
                {(stats?.resultsReadyOrders || 0) > 0 && (
                  <div className="px-2 py-0.5 bg-red-100 text-red-800 text-xs font-semibold rounded-full animate-pulse">
                    New
                  </div>
                )}
              </div>
              <div className="text-xl font-bold text-gray-900 mb-1">{stats?.resultsReadyOrders || 0}</div>
              <div className="text-gray-600 font-medium text-sm mb-1">Results Ready</div>
              <div className="text-xs text-gray-500">Download results</div>
            </div>
          </div>

          <div className="group relative overflow-hidden bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 hover:border-green-200">
            <div className="absolute inset-0 bg-gradient-to-br from-green-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div className="relative p-4">
              <div className="flex items-center justify-between mb-3">
                <div className="p-2 bg-green-100 rounded-lg group-hover:bg-green-200 transition-colors duration-300">
                  <CheckCircleIcon className="h-5 w-5 text-green-600" />
                </div>
              </div>
              <div className="text-xl font-bold text-gray-900 mb-1">{stats?.completedOrders || 0}</div>
              <div className="text-gray-600 font-medium text-sm mb-1">Completed</div>
              <div className="text-xs text-gray-500">View history</div>
            </div>
          </div>

          <div className="group relative overflow-hidden bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 hover:border-amber-200">
            <div className="absolute inset-0 bg-gradient-to-br from-amber-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div className="relative p-4">
              <div className="flex items-center justify-between mb-3">
                <div className="p-2 bg-amber-100 rounded-lg group-hover:bg-amber-200 transition-colors duration-300">
                  <CalendarDaysIcon className="h-5 w-5 text-amber-600" />
                </div>
              </div>
              <div className="text-xl font-bold text-gray-900 mb-1">{stats?.totalOrders || 0}</div>
              <div className="text-gray-600 font-medium text-sm mb-1">This Month</div>
              <div className="text-xs text-gray-500">All services</div>
            </div>
          </div>
        </div>

        {/* Compact Recent Orders */}
        {recentOrders && recentOrders.length > 0 && (
          <div className="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-100">
            <div className="px-4 sm:px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
              <div className="flex items-center justify-between">
                <div>
                  <h3 className="text-lg font-bold text-gray-900">Recent Orders</h3>
                  <p className="text-gray-600 text-xs mt-1 hidden sm:block">Your latest medical service requests</p>
                </div>
                <Link 
                  href="/orders" 
                  className="inline-flex items-center text-xs px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold rounded-lg transition-all duration-200 border border-blue-200"
                >
                  <ChartBarIcon className="h-3 w-3 mr-1" />
                  View All
                </Link>
              </div>
            </div>
            <div className="divide-y divide-gray-50">
              {recentOrders.slice(0, 5).map((order, index) => (
                <div
                  key={order.id}
                  className="px-4 sm:px-6 py-4 hover:bg-gray-50 transition-all duration-200 group"
                  style={{ animationDelay: `${index * 100}ms` }}
                >
                  <div className="flex items-center space-x-3">
                    <div
                      className={`h-10 w-10 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm group-hover:scale-110 transition-transform duration-200 ${
                        order.type === "test" 
                          ? "bg-gradient-to-br from-blue-100 to-blue-200" 
                          : "bg-gradient-to-br from-red-100 to-red-200"
                      }`}
                    >
                      {order.type === "test" ? (
                        <BeakerIcon className="h-5 w-5 text-blue-600" />
                      ) : (
                        <HeartIcon className="h-5 w-5 text-red-600" />
                      )}
                    </div>
                    
                    <div className="flex-1 min-w-0">
                      <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-1 sm:space-y-0">
                        <div className="min-w-0 flex-1">
                          <p className="text-sm font-semibold text-gray-900 truncate">
                            {order.test_type || `${order.type === "test" ? "Lab Test" : "Blood Service"}`}
                          </p>
                          <p className="text-xs text-gray-500 truncate">
                            Order #{order.id} • {order.facility_name}
                          </p>
                        </div>
                        <div className="flex items-center space-x-2">
                          <span
                            className={`inline-flex px-2 py-1 text-xs font-semibold rounded-full capitalize border ${getStatusColor(order.status)}`}
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
    </div>
  )
}