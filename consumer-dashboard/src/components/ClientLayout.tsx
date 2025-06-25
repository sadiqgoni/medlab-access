"use client"

import type React from "react"
import { useState } from "react"
import Link from "next/link"
import { usePathname } from "next/navigation"
import { cn } from "@/lib/utils"
import { useStore } from "@/store/useStore"

interface LayoutProps {
  children: React.ReactNode
}

const navigation = [
  {
    name: "Dashboard",
    href: "/dashboard",
    icon: "fa-home",
  },
  {
    name: "My Orders",
    href: "/orders",
    icon: "fa-clipboard-list",
  },
  {
    name: "New Order",
    href: "/orders/create",
    icon: "fa-plus",
  },
  {
    name: "My Profile",
    href: "/profile",
    icon: "fa-user",
  },
]

const quickActions = [
  {
    name: "Book Lab Test",
    href: "/orders/create?type=test",
    icon: "fa-vial",
    color: "blue" as const,
  },
  {
    name: "Blood Services",
    href: "/orders/create?type=blood",
    icon: "fa-tint",
    color: "red" as const,
  },
]

export default function ClientLayout({ children }: LayoutProps) {
  const [sidebarOpen, setSidebarOpen] = useState(false)
  const [showNotifications, setShowNotifications] = useState(false)
  const [userMenuOpen, setUserMenuOpen] = useState(false)
  const pathname = usePathname()
  const { user } = useStore()

  const isActive = (href: string) => {
    // Remove trailing slash for comparison
    const cleanPathname = pathname.endsWith('/') && pathname.length > 1 ? pathname.slice(0, -1) : pathname
    const cleanHref = href.endsWith('/') && href.length > 1 ? href.slice(0, -1) : href
    
    if (cleanHref === "/dashboard") return cleanPathname === "/dashboard" || cleanPathname === ""
    if (cleanHref === "/orders") {
      return cleanPathname === "/orders" || (cleanPathname.startsWith("/orders/") && !cleanPathname.includes("/create"))
    }
    if (cleanHref === "/orders/create") return cleanPathname === "/orders/create"
    if (cleanHref === "/profile") return cleanPathname === "/profile"
    
    return cleanPathname === cleanHref
  }

  return (
    <div className="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50">
      {/* Mobile sidebar backdrop */}
      {sidebarOpen && (
        <div
          className="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm lg:hidden transition-all duration-300"
          onClick={() => setSidebarOpen(false)}
        />
      )}

      {/* Mobile sidebar - Reduced width */}
      <div
        className={cn(
          "fixed inset-y-0 left-0 z-50 w-64 bg-white/95 backdrop-blur-xl shadow-2xl lg:hidden transition-transform ease-out duration-300 border-r border-slate-200",
          sidebarOpen ? "translate-x-0" : "-translate-x-full",
        )}
      >
        {/* Mobile Header */}
        <div className="flex items-center justify-between h-16 px-4 bg-gradient-to-r from-blue-700 to-blue-800 border-b border-blue-500/20">
          <div className="flex items-center space-x-3">
            <div className="h-8 w-8 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center overflow-hidden">
              <img src="/logodhr.jpg" alt="DHR" className="h-6 w-6 object-contain" />
            </div>
            <div>
              <span className="text-lg font-bold text-white">DHR SPACE</span>
              <p className="text-xs text-blue-100">Health Partner</p>
            </div>
          </div>
          <button
            onClick={() => setSidebarOpen(false)}
            className="p-2 text-white/80 hover:text-white hover:bg-white/10 rounded-lg transition-colors"
          >
            <i className="fas fa-times h-5 w-5" />
          </button>
        </div>

        {/* User Info Card */}
        <div className="p-4 bg-gradient-to-br from-slate-50 to-blue-50 border-b border-slate-200">
          <div className="flex items-center space-x-3">
            <div className="h-10 w-10 rounded-full bg-gradient-to-r from-blue-600 to-blue-700 flex items-center justify-center text-white font-semibold shadow-lg">
              {user?.name?.charAt(0) || "U"}
            </div>
            <div className="flex-1 min-w-0">
              <p className="font-semibold text-slate-900 truncate">{user?.name || "User"}</p>
              <p className="text-sm text-slate-600 truncate">{user?.email || "user@example.com"}</p>
              <div className="flex items-center mt-1">
                <div className="h-1.5 w-1.5 rounded-full bg-emerald-400"></div>
                <span className="text-xs text-emerald-600 font-medium ml-1">Active</span>
              </div>
            </div>
          </div>
        </div>

        {/* Mobile Navigation */}
        <nav className="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
          {navigation.map((item) => {
            const active = isActive(item.href)
            return (
              <Link
                key={item.name}
                href={item.href}
                className={cn(
                  "flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200",
                  active
                    ? "text-blue-700 bg-blue-50 shadow-sm border-l-4 border-blue-500"
                    : "text-slate-700 hover:bg-slate-50 hover:text-slate-900",
                )}
                onClick={() => setSidebarOpen(false)}
              >
                <i
                  className={cn(
                    "fas",
                    item.icon,
                    "h-5 w-5 mr-3 flex-shrink-0",
                    active ? "text-blue-600" : "text-slate-500",
                  )}
                />
                <span className="truncate">{item.name}</span>
                {active && <div className="ml-auto h-1.5 w-1.5 rounded-full bg-blue-500"></div>}
              </Link>
            )
          })}

          {/* Quick Actions */}
          <div className="pt-4 mt-4 border-t border-slate-200">
            <p className="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Quick Actions</p>
            <div className="space-y-1">
              {quickActions.map((action) => {
                return (
                  <Link
                    key={action.name}
                    href={action.href}
                    className={cn(
                      "flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors",
                      action.color === "blue"
                        ? "text-slate-700 hover:bg-blue-50 hover:text-blue-700"
                        : "text-slate-700 hover:bg-red-50 hover:text-red-700",
                    )}
                    onClick={() => setSidebarOpen(false)}
                  >
                    <i
                      className={cn(
                        "fas",
                        action.icon,
                        "h-4 w-4 mr-3 flex-shrink-0",
                        action.color === "blue" ? "text-blue-500" : "text-red-500",
                      )}
                    />
                    <span className="truncate">{action.name}</span>
                  </Link>
                )
              })}
            </div>
          </div>

          {/* Logout */}
          <div className="pt-4 mt-4 border-t border-slate-200">
            <button
              className="flex items-center w-full px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-red-50 hover:text-red-700 rounded-lg transition-colors"
              onClick={() => {
                console.log("Logout clicked")
              }}
            >
              <i className="fas fa-sign-out-alt h-5 w-5 mr-3 flex-shrink-0 text-slate-500" />
              <span>Sign Out</span>
            </button>
          </div>
        </nav>
      </div>

      {/* Desktop sidebar - Reduced width */}
      <div className="hidden lg:flex lg:flex-col lg:w-64 lg:fixed lg:inset-y-0 lg:bg-white/95 lg:backdrop-blur-xl lg:shadow-xl lg:border-r lg:border-slate-200">
        {/* Desktop Header */}
        <div className="flex items-center h-16 px-4 bg-gradient-to-r from-blue-700 to-blue-800 border-b border-blue-500/20">
          <div className="flex items-center space-x-3">
            <div className="h-9 w-9 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center overflow-hidden">
              <img src="/logodhr.jpg" alt="DHR" className="h-7 w-7 object-contain" />
            </div>
            <div>
              <span className="text-xl font-bold text-white">DHR SPACE</span>
              <p className="text-sm text-blue-100">Health Partner</p>
            </div>
          </div>
        </div>

        {/* User Info Card */}
        <div className="p-4 bg-gradient-to-br from-slate-50 to-blue-50 border-b border-slate-200">
          <div className="flex items-center space-x-3">
            <div className="h-12 w-12 rounded-full bg-gradient-to-r from-blue-600 to-blue-700 flex items-center justify-center text-white font-semibold text-lg shadow-lg">
              {user?.name?.charAt(0) || "U"}
            </div>
            <div className="flex-1 min-w-0">
              <p className="font-semibold text-slate-900 truncate">{user?.name || "User"}</p>
              <p className="text-sm text-slate-600 truncate">{user?.email || "user@example.com"}</p>
              <div className="flex items-center mt-1.5">
                <div className="h-2 w-2 rounded-full bg-emerald-400"></div>
                <span className="text-xs text-emerald-600 font-medium ml-2">Active Account</span>
              </div>
            </div>
          </div>
        </div>

        {/* Desktop Navigation */}
        <nav className="flex-1 px-3 py-6 space-y-2 overflow-y-auto">
          {navigation.map((item) => {
            const active = isActive(item.href)
            return (
              <Link
                key={item.name}
                href={item.href}
                className={cn(
                  "flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 group",
                  active
                    ? "text-blue-700 bg-blue-50 shadow-sm border-l-4 border-blue-500"
                    : "text-slate-700 hover:bg-slate-50 hover:text-slate-900",
                )}
              >
                <i
                  className={cn(
                    "fas",
                    item.icon,
                    "h-5 w-5 mr-3 flex-shrink-0 transition-colors",
                    active ? "text-blue-600" : "text-slate-500 group-hover:text-slate-700",
                  )}
                />
                <span className="truncate">{item.name}</span>
                {active && <div className="ml-auto h-2 w-2 rounded-full bg-blue-500"></div>}
              </Link>
            )
          })}

          {/* Quick Actions */}
          <div className="pt-6 mt-6 border-t border-slate-200">
            <p className="px-3 text-xs font-bold text-slate-500 uppercase tracking-wider mb-4">Quick Actions</p>
            <div className="space-y-2">
              {quickActions.map((action) => {
                return (
                  <Link
                    key={action.name}
                    href={action.href}
                    className={cn(
                      "flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors group",
                      action.color === "blue"
                        ? "text-slate-700 hover:bg-blue-50 hover:text-blue-700"
                        : "text-slate-700 hover:bg-red-50 hover:text-red-700",
                    )}
                  >
                    <i
                      className={cn(
                        "fas",
                        action.icon,
                        "h-5 w-5 mr-3 flex-shrink-0",
                        action.color === "blue" ? "text-blue-500" : "text-red-500",
                      )}
                    />
                    <span className="truncate">{action.name}</span>
                  </Link>
                )
              })}
            </div>
          </div>

          {/* Support Section */}
          <div className="pt-4 mt-4">
            <div className="px-3 py-3 bg-gradient-to-r from-blue-50 to-blue-50 rounded-lg border border-blue-100">
              <div className="flex items-center space-x-3">
                <div className="h-8 w-8 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
                  <i className="fas fa-question-circle h-4 w-4 text-blue-600" />
                </div>
                <div className="flex-1 min-w-0">
                  <p className="text-sm font-medium text-slate-900">Need Help?</p>
                  <p className="text-xs text-slate-600">Contact support</p>
                </div>
              </div>
            </div>
          </div>

          {/* Logout */}
          <div className="pt-4 border-t border-slate-200">
            <button
              className="flex items-center w-full px-3 py-3 text-sm font-medium text-slate-700 hover:bg-red-50 hover:text-red-700 rounded-lg transition-colors group"
              onClick={() => {
                console.log("Logout clicked")
              }}
            >
              <i className="fas fa-sign-out-alt h-5 w-5 mr-3 flex-shrink-0 text-slate-500 group-hover:text-red-500 transition-colors" />
              <span>Sign Out</span>
            </button>
          </div>
        </nav>
      </div>

      {/* Main content */}
      <div className="lg:pl-64">
        {/* Top navigation */}
        <div className="sticky top-0 z-30 flex h-14 sm:h-16 items-center gap-x-2 sm:gap-x-4 border-b border-slate-200 bg-white/95 backdrop-blur-sm px-2 sm:px-4 shadow-sm lg:gap-x-6 lg:px-8">
          <button
            type="button"
            className="p-2 text-slate-700 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-colors lg:hidden"
            onClick={() => setSidebarOpen(true)}
          >
            <span className="sr-only">Open sidebar</span>
            <i className="fas fa-bars h-5 w-5" />
          </button>

          <div className="h-6 w-px bg-slate-200 lg:hidden" />

          <div className="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
            <div className="flex flex-1 items-center">{/* Empty space for future content */}</div>

            <div className="flex items-center gap-x-2">
              {/* Notifications */}
              <div className="relative">
                <button
                  className="p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-lg transition-colors"
                  onClick={() => setShowNotifications(!showNotifications)}
                >
                  <span className="sr-only">View notifications</span>
                  <i className="fas fa-bell h-5 w-5" />
                  <div className="absolute -top-1 -right-1 h-3 w-3 rounded-full bg-red-500 animate-pulse"></div>
                </button>

                {/* Notifications Dropdown */}
                {showNotifications && (
                  <>
                    <div 
                      className="fixed inset-0 z-10" 
                      onClick={() => setShowNotifications(false)}
                    />
                    <div className="absolute right-0 mt-2 w-72 sm:w-80 md:w-96 bg-white rounded-lg shadow-lg border border-gray-200 z-20 max-h-80 sm:max-h-96 overflow-hidden">
                      <div className="p-4 border-b border-gray-200">
                        <div className="flex items-center justify-between">
                          <h3 className="text-lg font-semibold text-gray-900">Notifications</h3>
                          <button
                            onClick={() => setShowNotifications(false)}
                            className="text-gray-400 hover:text-gray-600"
                          >
                            <i className="fas fa-times h-4 w-4" />
                          </button>
                        </div>
                      </div>
                      <div className="max-h-80 overflow-y-auto">
                        {/* Sample notifications */}
                        <div className="p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors">
                          <div className="flex items-start space-x-3">
                            <div className="flex-shrink-0">
                              <div className="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                <i className="fas fa-check h-4 w-4 text-green-600" />
                              </div>
                            </div>
                            <div className="flex-1 min-w-0">
                              <p className="text-sm font-medium text-gray-900">Lab Results Ready</p>
                              <p className="text-sm text-gray-600">Your Full Blood Count results are now available</p>
                              <p className="text-xs text-gray-500 mt-1">2 hours ago</p>
                            </div>
                          </div>
                        </div>
                        
                        <div className="p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors">
                          <div className="flex items-start space-x-3">
                            <div className="flex-shrink-0">
                              <div className="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                <i className="fas fa-calendar h-4 w-4 text-blue-600" />
                              </div>
                            </div>
                            <div className="flex-1 min-w-0">
                              <p className="text-sm font-medium text-gray-900">Appointment Reminder</p>
                              <p className="text-sm text-gray-600">Your home collection is scheduled for tomorrow at 10:00 AM</p>
                              <p className="text-xs text-gray-500 mt-1">5 hours ago</p>
                            </div>
                          </div>
                        </div>
                        
                        <div className="p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors">
                          <div className="flex items-start space-x-3">
                            <div className="flex-shrink-0">
                              <div className="h-8 w-8 rounded-full bg-yellow-100 flex items-center justify-center">
                                <i className="fas fa-exclamation-triangle h-4 w-4 text-yellow-600" />
                              </div>
                            </div>
                            <div className="flex-1 min-w-0">
                              <p className="text-sm font-medium text-gray-900">Payment Pending</p>
                              <p className="text-sm text-gray-600">Please complete payment for your recent order</p>
                              <p className="text-xs text-gray-500 mt-1">1 day ago</p>
                            </div>
                          </div>
                        </div>
                        
                        <div className="p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors">
                          <div className="flex items-start space-x-3">
                            <div className="flex-shrink-0">
                              <div className="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center">
                                <i className="fas fa-gift h-4 w-4 text-purple-600" />
                              </div>
                            </div>
                            <div className="flex-1 min-w-0">
                              <p className="text-sm font-medium text-gray-900">Special Offer</p>
                              <p className="text-sm text-gray-600">Get 20% off on your next comprehensive health package</p>
                              <p className="text-xs text-gray-500 mt-1">2 days ago</p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div className="p-4 bg-gray-50 border-t border-gray-200">
                        <button className="w-full text-center text-sm text-blue-600 hover:text-blue-800 font-medium">
                          View All Notifications
                        </button>
                      </div>
                    </div>
                  </>
                )}
              </div>

              {/* Profile dropdown */}
              <div className="relative">
                <button
                  className="flex items-center rounded-full bg-white p-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-sm border border-slate-200 hover:shadow-md transition-all"
                  onClick={() => setUserMenuOpen(!userMenuOpen)}
                >
                  <span className="sr-only">Open user menu</span>
                  <div className="h-8 w-8 rounded-full bg-gradient-to-r from-blue-600 to-blue-700 flex items-center justify-center text-white font-semibold text-sm">
                    {user?.name?.charAt(0) || "U"}
                  </div>
                </button>
              </div>
            </div>
          </div>
        </div>

        {/* Page content */}
        <main className="py-4 sm:py-6">
          <div className="mx-auto max-w-7xl px-3 sm:px-4 lg:px-6 xl:px-8">{children}</div>
        </main>
      </div>
    </div>
  )
}
