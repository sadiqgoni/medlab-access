'use client';

import React, { useState } from 'react';
import Link from 'next/link';
import { usePathname } from 'next/navigation';
import { cn } from '@/lib/utils';
import { useStore } from '@/store/useStore';

interface LayoutProps {
  children: React.ReactNode;
}

const navigation = [
  { 
    name: 'Dashboard', 
    href: '/dashboard', 
    icon: 'fa-home'
  },
  { 
    name: 'My Orders', 
    href: '/orders', 
    icon: 'fa-clipboard-list'
  },
  { 
    name: 'New Order', 
    href: '/orders/create', 
    icon: 'fa-plus'
  },
  { 
    name: 'My Profile', 
    href: '/profile', 
    icon: 'fa-user'
  },
];

const quickActions = [
  {
    name: 'Book Lab Test',
    href: '/orders/create?type=test',
    icon: 'fa-vial',
    color: 'blue'
  },
  {
    name: 'Blood Services',
    href: '/orders/create?type=blood',
    icon: 'fa-tint',
    color: 'red'
  }
];

export default function Layout({ children }: LayoutProps) {
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const [showNotifications, setShowNotifications] = useState(false);
  const [userMenuOpen, setUserMenuOpen] = useState(false);
  const pathname = usePathname();
  const { user } = useStore();

  const isActive = (href: string) => {
    if (href === '/dashboard') return pathname === '/dashboard';
    if (href === '/orders') return pathname === '/orders' || pathname.startsWith('/orders/');
    return pathname === href;
  };

  return (
    <>
      {/* Include Font Awesome */}
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
      
      <div className="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50">
        {/* Mobile sidebar backdrop */}
        {sidebarOpen && (
          <div 
            className="fixed inset-0 z-40 bg-gray-900 bg-opacity-50 lg:hidden transition-opacity ease-linear duration-300"
            onClick={() => setSidebarOpen(false)}
          />
        )}

        {/* Enhanced Mobile sidebar */}
        <div className={cn(
          "fixed inset-y-0 left-0 z-50 w-72 bg-white shadow-2xl lg:hidden transition-transform ease-in-out duration-300",
          sidebarOpen ? "translate-x-0" : "-translate-x-full"
        )}>
          {/* Mobile Header */}
          <div className="flex items-center justify-between h-20 px-6 bg-gradient-to-r from-blue-700 to-blue-800">
            <div className="flex items-center">
              <div className="h-10 w-10 rounded-xl bg-white/20 flex items-center justify-center mr-3">
                <i className="fas fa-heartbeat text-white text-lg"></i>
              </div>
              <div>
                <span className="text-xl font-bold text-white">DHR SPACE</span>
                <p className="text-xs text-blue-100">Your Health Partner</p>
              </div>
            </div>
            <button 
              onClick={() => setSidebarOpen(false)} 
              className="text-white hover:text-blue-200 transition-colors"
            >
              <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>
          
          {/* User Info Card */}
          <div className="p-6 bg-gradient-to-br from-blue-50 to-blue-50 border-b">
            <div className="flex items-center">
              <div className="h-12 w-12 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                {user?.name?.charAt(0) || 'U'}
              </div>
              <div className="ml-4">
                <p className="font-semibold text-gray-900">{user?.name || 'User'}</p>
                <p className="text-sm text-gray-600">{user?.email || 'user@example.com'}</p>
                <div className="flex items-center mt-1">
                  <div className="h-2 w-2 rounded-full bg-green-400 mr-2"></div>
                  <span className="text-xs text-green-600 font-medium">Active</span>
                </div>
              </div>
            </div>
          </div>
          
          {/* Mobile Navigation */}
          <nav className="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            {navigation.map((item) => {
              const active = isActive(item.href);
              return (
                <Link
                  key={item.name}
                  href={item.href}
                  className={cn(
                    "flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200",
                    active 
                      ? "text-blue-700 bg-blue-50 border-r-4 border-blue-500" 
                      : "text-gray-700 hover:bg-gray-50"
                  )}
                  onClick={() => setSidebarOpen(false)}
                >
                  <div className={cn(
                    "h-8 w-8 rounded-lg flex items-center justify-center mr-3",
                    active ? "bg-blue-100" : "bg-gray-100"
                  )}>
                    <i className={cn(
                      `fas ${item.icon}`,
                      active ? "text-blue-600" : "text-gray-500"
                    )}></i>
                  </div>
                  <span>{item.name}</span>
                  {active && (
                    <div className="ml-auto h-2 w-2 rounded-full bg-blue-500"></div>
                  )}
                </Link>
              );
            })}

            {/* Quick Actions */}
            <div className="pt-6 mt-6 border-t border-gray-200">
              <p className="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Quick Actions</p>
              <div className="space-y-2">
                {quickActions.map((action) => (
                  <Link
                    key={action.name}
                    href={action.href}
                    className={cn(
                      "flex items-center px-4 py-2 text-sm text-gray-700 rounded-lg transition-colors",
                      action.color === 'blue' ? "hover:bg-blue-50 hover:text-blue-700" : "hover:bg-red-50 hover:text-red-700"
                    )}
                  >
                    <i className={cn(
                      `fas ${action.icon} mr-3`,
                      action.color === 'blue' ? "text-blue-500" : "text-red-500"
                    )}></i>
                    <span>{action.name}</span>
                  </Link>
                ))}
              </div>
            </div>

            {/* Logout */}
            <div className="pt-6 mt-6 border-t border-gray-200">
              <button 
                className="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 rounded-lg transition-colors"
                onClick={() => {
                  // Handle logout
                  console.log('Logout clicked');
                }}
              >
                <div className="h-8 w-8 rounded-lg bg-gray-100 flex items-center justify-center mr-3">
                  <i className="fas fa-sign-out-alt text-gray-500"></i>
                </div>
                <span>Sign Out</span>
              </button>
            </div>
          </nav>
        </div>

        {/* Enhanced Desktop sidebar */}
        <div className="hidden lg:flex lg:flex-col lg:w-72 lg:fixed lg:inset-y-0 lg:bg-white lg:shadow-xl lg:border-r lg:border-gray-200">
          {/* Desktop Header */}
          <div className="flex items-center h-20 px-6 bg-gradient-to-r from-blue-700 to-blue-800">
            <div className="flex items-center">
              <div className="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center mr-4">
                <i className="fas fa-heartbeat text-white text-xl"></i>
              </div>
              <div>
                <span className="text-2xl font-bold text-white">DHR SPACE</span>
                <p className="text-sm text-blue-100">Your Health Partner</p>
              </div>
            </div>
          </div>
          
          {/* User Info Card */}
          <div className="p-6 bg-gradient-to-br from-blue-50 to-blue-50 border-b">
            <div className="flex items-center">
              <div className="h-14 w-14 rounded-full bg-gradient-to-r from-blue-600 to-blue-700 flex items-center justify-center text-white font-bold text-xl shadow-lg">
                {user?.name?.charAt(0) || 'U'}
              </div>
              <div className="ml-4">
                <p className="font-semibold text-gray-900">{user?.name || 'User'}</p>
                <p className="text-sm text-gray-600">{user?.email || 'user@example.com'}</p>
                <div className="flex items-center mt-2">
                  <div className="h-2 w-2 rounded-full bg-green-400 mr-2"></div>
                  <span className="text-xs text-green-600 font-medium">Active Account</span>
                </div>
              </div>
            </div>
          </div>
          
          {/* Desktop Navigation */}
          <nav className="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            {navigation.map((item) => {
              const active = isActive(item.href);
              return (
                <Link
                  key={item.name}
                  href={item.href}
                  className={cn(
                    "flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 group",
                    active 
                      ? "text-blue-700 bg-blue-50 border-r-4 border-blue-500" 
                      : "text-gray-700 hover:bg-gray-50"
                  )}
                >
                  <div className={cn(
                    "h-10 w-10 rounded-lg flex items-center justify-center mr-3 transition-colors",
                    active ? "bg-blue-100" : "bg-gray-100 group-hover:bg-blue-50"
                  )}>
                    <i className={cn(
                      `fas ${item.icon}`,
                      active ? "text-blue-600" : "text-gray-500 group-hover:text-blue-500"
                    )}></i>
                  </div>
                  <span>{item.name}</span>
                  {active && (
                    <div className="ml-auto h-2 w-2 rounded-full bg-blue-500"></div>
                  )}
                </Link>
              );
            })}

            {/* Quick Actions */}
            <div className="pt-6 mt-6 border-t border-gray-200">
              <p className="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Quick Actions</p>
              <div className="space-y-2">
                {quickActions.map((action) => (
                  <Link
                    key={action.name}
                    href={action.href}
                    className={cn(
                      "flex items-center px-4 py-3 text-sm text-gray-700 rounded-lg transition-colors group",
                      action.color === 'blue' ? "hover:bg-blue-50 hover:text-blue-700" : "hover:bg-red-50 hover:text-red-700"
                    )}
                  >
                    <div className={cn(
                      "h-8 w-8 rounded-lg bg-gray-100 flex items-center justify-center mr-3 transition-colors",
                      action.color === 'blue' ? "group-hover:bg-blue-50" : "group-hover:bg-red-50"
                    )}>
                      <i className={cn(
                        `fas ${action.icon}`,
                        action.color === 'blue' ? "text-blue-500" : "text-red-500"
                      )}></i>
                    </div>
                    <span>{action.name}</span>
                  </Link>
                ))}
              </div>
            </div>

            {/* Support Section */}
            <div className="pt-6 mt-6 border-t border-gray-200">
              <div className="px-4 py-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg">
                <div className="flex items-center">
                  <div className="h-8 w-8 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                    <i className="fas fa-question-circle text-blue-600"></i>
                  </div>
                  <div className="flex-1">
                    <p className="text-sm font-medium text-gray-900">Need Help?</p>
                    <p className="text-xs text-gray-600">Contact support</p>
                  </div>
                </div>
              </div>
            </div>

            {/* Logout */}
            <div className="pt-6 border-t border-gray-200">
              <button 
                className="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 rounded-lg transition-colors group"
                onClick={() => {
                  // Handle logout
                  console.log('Logout clicked');
                }}
              >
                <div className="h-10 w-10 rounded-lg bg-gray-100 group-hover:bg-red-50 flex items-center justify-center mr-3 transition-colors">
                  <i className="fas fa-sign-out-alt text-gray-500 group-hover:text-red-500"></i>
                </div>
                <span>Sign Out</span>
              </button>
            </div>
          </nav>
        </div>

        {/* Main content */}
        <div className="lg:pl-72">
          {/* Enhanced Top navigation */}
          <div className="sticky top-0 z-30 flex h-20 items-center gap-x-4 border-b border-gray-200 bg-white/95 backdrop-blur-sm px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
            <button
              type="button"
              className="-m-2.5 p-2.5 text-gray-700 lg:hidden"
              onClick={() => setSidebarOpen(true)}
            >
              <span className="sr-only">Open sidebar</span>
              <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
              </svg>
            </button>

            <div className="h-6 w-px bg-gray-200 lg:hidden" />

            <div className="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
              <div className="flex flex-1 items-center">
                <div className="flex-1 flex items-center">
                  <div className="hidden lg:block">
                    <h1 className="text-2xl font-bold text-gray-900">DHR SPACE</h1>
                    <p className="text-gray-600">Your Health Dashboard</p>
                  </div>
                </div>
              </div>
              
              <div className="flex items-center gap-x-4 lg:gap-x-6">
                {/* Notifications */}
                <div className="relative">
                  <button 
                    className="p-2 text-gray-400 hover:text-gray-500 transition-colors"
                    onClick={() => setShowNotifications(!showNotifications)}
                  >
                    <span className="sr-only">View notifications</span>
                    <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor">
                      <path strokeLinecap="round" strokeLinejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                    <div className="absolute -top-1 -right-1 h-3 w-3 rounded-full bg-red-500 animate-pulse"></div>
                  </button>
                </div>

                <div className="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-200" />

                {/* Profile dropdown */}
                <div className="relative">
                  <button 
                    className="flex max-w-xs items-center rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    onClick={() => setUserMenuOpen(!userMenuOpen)}
                  >
                    <span className="sr-only">Open user menu</span>
                    <div className="h-8 w-8 rounded-full bg-gradient-to-r from-blue-600 to-blue-700 flex items-center justify-center text-white font-bold text-sm">
                      {user?.name?.charAt(0) || 'U'}
                    </div>
                  </button>
                </div>
              </div>
            </div>
          </div>

          {/* Page content */}
          <main className="py-8">
            <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
              {children}
            </div>
          </main>
        </div>
      </div>
    </>
  );
}