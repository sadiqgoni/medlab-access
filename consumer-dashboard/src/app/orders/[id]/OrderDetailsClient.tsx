'use client';

import React, { useEffect, useState } from 'react';
import { useRouter } from 'next/navigation';
import Link from 'next/link';
import { 
  ArrowLeftIcon,
  MapPinIcon,
  ClockIcon,
  PhoneIcon,
  UserIcon,
  TruckIcon,
  BeakerIcon,
  HeartIcon,
  DocumentArrowDownIcon,
  CheckCircleIcon,
  ExclamationTriangleIcon,
  ChatBubbleLeftRightIcon,
  StarIcon,
  CreditCardIcon,
  CalendarDaysIcon,
  IdentificationIcon,
  BuildingOffice2Icon
} from '@heroicons/react/24/outline';
import { useStore } from '@/store/useStore';
import { formatDate, formatCurrency } from '@/lib/utils';
import { Order } from '@/types';

const statusConfig = {
  pending: {
    color: 'bg-yellow-100 text-yellow-800 border-yellow-200',
    icon: ClockIcon,
    message: 'Your order has been received and is being processed.',
    nextStep: 'Facility confirmation'
  },
  confirmed: {
    color: 'bg-blue-100 text-blue-800 border-blue-200',
    icon: CheckCircleIcon,
    message: 'Your order has been confirmed by the facility.',
    nextStep: 'Sample collection scheduling'
  },
  in_progress: {
    color: 'bg-blue-100 text-blue-800 border-blue-200',
    icon: TruckIcon,
    message: 'Sample collection is in progress.',
    nextStep: 'Lab processing'
  },
  completed: {
    color: 'bg-green-100 text-green-800 border-green-200',
    icon: CheckCircleIcon,
    message: 'Your order has been completed successfully.',
    nextStep: 'Results available'
  },
  cancelled: {
    color: 'bg-red-100 text-red-800 border-red-200',
    icon: ExclamationTriangleIcon,
    message: 'This order has been cancelled.',
    nextStep: 'Contact support if needed'
  }
};

// Mock biker data for demonstration
const mockBiker = {
  id: 'BK001',
  name: 'Adebayo Ogundimu',
  phone: '+234 803 123 4567',
  rating: 4.8,
  totalDeliveries: 1247,
  profileImage: '/images/biker-profile.jpg',
  vehicleType: 'Motorcycle',
  licensePlate: 'LAG-123-ABC',
  currentLocation: 'En route to pickup location',
  estimatedArrival: '15 minutes'
};

interface OrderDetailsClientProps {
  orderId: string;
}

export default function OrderDetailsClient({ orderId }: OrderDetailsClientProps) {
  const router = useRouter();
  const { orders, loading, fetchOrders } = useStore();
  const [order, setOrder] = useState<Order | null>(null);
  const [trackingUpdates, setTrackingUpdates] = useState([
    {
      id: 1,
      status: 'Order Placed',
      description: 'Your order has been successfully placed',
      timestamp: '2024-01-20T09:00:00Z',
      completed: true
    },
    {
      id: 2,
      status: 'Facility Confirmed',
      description: 'Medical facility has confirmed your order',
      timestamp: '2024-01-20T09:30:00Z',
      completed: true
    },
    {
      id: 3,
      status: 'Biker Assigned',
      description: 'Collection agent has been assigned',
      timestamp: '2024-01-20T10:00:00Z',
      completed: true
    },
    {
      id: 4,
      status: 'En Route to Pickup',
      description: 'Collection agent is heading to your location',
      timestamp: '2024-01-20T10:15:00Z',
      completed: false,
      current: true
    },
    {
      id: 5,
      status: 'Sample Collected',
      description: 'Sample has been collected successfully',
      timestamp: null,
      completed: false
    },
    {
      id: 6,
      status: 'Lab Processing',
      description: 'Sample is being processed at the laboratory',
      timestamp: null,
      completed: false
    },
    {
      id: 7,
      status: 'Results Ready',
      description: 'Your test results are ready for download',
      timestamp: null,
      completed: false
    }
  ]);

  useEffect(() => {
    if (orders.length === 0) {
      fetchOrders();
    }
  }, [orders.length, fetchOrders]);

  useEffect(() => {
    if (orders.length > 0 && orderId) {
      const foundOrder = orders.find(o => o.id.toString() === orderId);
      setOrder(foundOrder || null);
    }
  }, [orders, orderId]);

  if (loading) {
    return (
      <div className="flex items-center justify-center min-h-96">
        <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
      </div>
    );
  }

  if (!order) {
    return (
      <div className="text-center py-12">
        <h2 className="text-2xl font-bold text-gray-900 mb-4">Order not found</h2>
        <p className="text-gray-600 mb-6">The order you're looking for doesn't exist or may have been removed.</p>
        <Link
          href="/orders"
          className="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
        >
          <ArrowLeftIcon className="w-4 h-4 mr-2" />
          Back to Orders
        </Link>
      </div>
    );
  }

  const statusInfo = statusConfig[order.status];
  const StatusIcon = statusInfo.icon;

  return (
    <div className="space-y-6">
      {/* Header */}
      <div className="flex items-center justify-between">
        <div className="flex items-center space-x-4">
          <button
            onClick={() => router.back()}
            className="p-2 hover:bg-gray-100 rounded-lg transition-colors"
          >
            <ArrowLeftIcon className="w-5 h-5" />
          </button>
          <div>
            <h1 className="text-2xl font-bold text-gray-900">Order Details</h1>
            <p className="text-gray-600">Order #{order.id}</p>
          </div>
        </div>
        
        <div className="flex items-center space-x-3">
          {order.results_ready && order.results_url && (
            <Link
              href={`/orders/${order.id}/results`}
              className="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
            >
              <DocumentArrowDownIcon className="w-4 h-4 mr-2" />
              View Results
            </Link>
          )}
          <button className="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
            <ChatBubbleLeftRightIcon className="w-4 h-4 mr-2" />
            Contact Support
          </button>
        </div>
      </div>

      {/* Status Banner */}
      <div className={`rounded-xl border p-6 ${statusInfo.color}`}>
        <div className="flex items-center">
          <StatusIcon className="w-8 h-8 mr-4" />
          <div className="flex-1">
            <h3 className="text-lg font-semibold capitalize">{order.status.replace('_', ' ')}</h3>
            <p className="mt-1">{statusInfo.message}</p>
            <p className="text-sm mt-2 opacity-75">Next: {statusInfo.nextStep}</p>
          </div>
          <div className="text-right">
            <div className="text-sm opacity-75">Order Date</div>
            <div className="font-medium">{formatDate(order.created_at)}</div>
          </div>
        </div>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {/* Main Content */}
        <div className="lg:col-span-2 space-y-6">
          {/* Order Information */}
          <div className="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 className="text-lg font-semibold text-gray-900 mb-4">Order Information</h3>
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div className="space-y-4">
                <div className="flex items-center space-x-3">
                  {order.type === 'test' ? (
                    <BeakerIcon className="h-5 w-5 text-blue-600" />
                  ) : (
                    <HeartIcon className="h-5 w-5 text-red-600" />
                  )}
                  <div>
                    <div className="text-sm text-gray-500">Service Type</div>
                    <div className="font-medium">
                      {order.test_type || (order.type === 'test' ? 'Laboratory Test' : 'Blood Service')}
                    </div>
                  </div>
                </div>

                <div className="flex items-center space-x-3">
                  <BuildingOffice2Icon className="h-5 w-5 text-gray-400" />
                  <div>
                    <div className="text-sm text-gray-500">Medical Facility</div>
                    <div className="font-medium">{order.facility_name}</div>
                    {order.facility_address && (
                      <div className="text-sm text-gray-600">{order.facility_address}</div>
                    )}
                  </div>
                </div>

                {order.scheduled_date && (
                  <div className="flex items-center space-x-3">
                    <CalendarDaysIcon className="h-5 w-5 text-gray-400" />
                    <div>
                      <div className="text-sm text-gray-500">Scheduled Date</div>
                      <div className="font-medium">{formatDate(order.scheduled_date)}</div>
                    </div>
                  </div>
                )}
              </div>

              <div className="space-y-4">
                <div className="flex items-center space-x-3">
                  <CreditCardIcon className="h-5 w-5 text-gray-400" />
                  <div>
                    <div className="text-sm text-gray-500">Payment Status</div>
                    <div className={`font-medium capitalize ${
                      order.payment_status === 'paid' ? 'text-green-600' :
                      order.payment_status === 'failed' ? 'text-red-600' :
                      'text-yellow-600'
                    }`}>
                      {order.payment_status}
                    </div>
                  </div>
                </div>

                <div className="flex items-center space-x-3">
                  <div className="h-5 w-5 rounded-full bg-blue-100 flex items-center justify-center">
                    <span className="text-xs font-bold text-blue-600">₦</span>
                  </div>
                  <div>
                    <div className="text-sm text-gray-500">Total Amount</div>
                    <div className="font-medium text-lg">{formatCurrency(order.total_amount)}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {/* Biker Information */}
          {order.status !== 'pending' && order.status !== 'cancelled' && (
            <div className="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
              <h3 className="text-lg font-semibold text-gray-900 mb-4">Collection Agent</h3>
              <div className="flex items-center space-x-4 mb-4">
                <div className="h-16 w-16 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-xl">
                  {mockBiker.name.charAt(0)}
                </div>
                <div className="flex-1">
                  <h4 className="text-lg font-semibold text-gray-900">{mockBiker.name}</h4>
                  <div className="flex items-center space-x-4 text-sm text-gray-600">
                    <div className="flex items-center">
                      <StarIcon className="w-4 h-4 text-yellow-400 fill-current mr-1" />
                      <span>{mockBiker.rating}</span>
                    </div>
                    <span>•</span>
                    <span>{mockBiker.totalDeliveries} deliveries</span>
                  </div>
                  <div className="flex items-center space-x-4 mt-2">
                    <a 
                      href={`tel:${mockBiker.phone}`}
                      className="flex items-center text-blue-600 hover:text-blue-700"
                    >
                      <PhoneIcon className="w-4 h-4 mr-1" />
                      {mockBiker.phone}
                    </a>
                  </div>
                </div>
              </div>

              <div className="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div className="bg-gray-50 rounded-lg p-3">
                  <div className="text-gray-500">Vehicle</div>
                  <div className="font-medium">{mockBiker.vehicleType}</div>
                  <div className="text-xs text-gray-600">{mockBiker.licensePlate}</div>
                </div>
                <div className="bg-gray-50 rounded-lg p-3">
                  <div className="text-gray-500">Status</div>
                  <div className="font-medium">{mockBiker.currentLocation}</div>
                </div>
                <div className="bg-gray-50 rounded-lg p-3">
                  <div className="text-gray-500">ETA</div>
                  <div className="font-medium text-blue-600">{mockBiker.estimatedArrival}</div>
                </div>
              </div>
            </div>
          )}

          {/* Tracking Timeline */}
          <div className="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 className="text-lg font-semibold text-gray-900 mb-6">Order Tracking</h3>
            <div className="space-y-6">
              {trackingUpdates.map((update, index) => (
                <div key={update.id} className="flex items-start space-x-4">
                  <div className={`flex-shrink-0 w-3 h-3 rounded-full mt-2 ${
                    update.completed ? 'bg-green-500' : 
                    update.current ? 'bg-blue-500' : 
                    'bg-gray-300'
                  }`} />
                  <div className="flex-1 min-w-0">
                    <div className={`text-sm font-medium ${
                      update.completed ? 'text-green-700' :
                      update.current ? 'text-blue-700' :
                      'text-gray-500'
                    }`}>
                      {update.status}
                    </div>
                    <div className="text-sm text-gray-600 mt-1">
                      {update.description}
                    </div>
                    {update.timestamp && (
                      <div className="text-xs text-gray-500 mt-1">
                        {formatDate(update.timestamp)}
                      </div>
                    )}
                  </div>
                  {update.current && (
                    <div className="flex-shrink-0">
                      <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        Current
                      </span>
                    </div>
                  )}
                </div>
              ))}
            </div>
          </div>
        </div>

        {/* Sidebar */}
        <div className="space-y-6">
          {/* Quick Actions */}
          <div className="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 className="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
            <div className="space-y-3">
              {order.results_ready && order.results_url && (
                <Link
                  href={`/orders/${order.id}/results`}
                  className="w-full flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
                >
                  <DocumentArrowDownIcon className="w-4 h-4 mr-2" />
                  Download Results
                </Link>
              )}
              
              {order.status === 'pending' && (
                <button className="w-full flex items-center justify-center px-4 py-2 border border-red-300 text-red-700 rounded-lg hover:bg-red-50 transition-colors">
                  <ExclamationTriangleIcon className="w-4 h-4 mr-2" />
                  Cancel Order
                </button>
              )}

              <button className="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                <ChatBubbleLeftRightIcon className="w-4 h-4 mr-2" />
                Contact Support
              </button>

              {order.status !== 'pending' && order.status !== 'cancelled' && (
                <a
                  href={`tel:${mockBiker.phone}`}
                  className="w-full flex items-center justify-center px-4 py-2 border border-blue-300 text-blue-700 rounded-lg hover:bg-blue-50 transition-colors"
                >
                  <PhoneIcon className="w-4 h-4 mr-2" />
                  Call Agent
                </a>
              )}
            </div>
          </div>

          {/* Order Summary */}
          <div className="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 className="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>
            <div className="space-y-3 text-sm">
              <div className="flex justify-between">
                <span className="text-gray-600">Order ID</span>
                <span className="font-medium">#{order.id}</span>
              </div>
              <div className="flex justify-between">
                <span className="text-gray-600">Placed On</span>
                <span className="font-medium">{formatDate(order.created_at)}</span>
              </div>
              {order.scheduled_date && (
                <div className="flex justify-between">
                  <span className="text-gray-600">Scheduled</span>
                  <span className="font-medium">{formatDate(order.scheduled_date)}</span>
                </div>
              )}
              <div className="flex justify-between">
                <span className="text-gray-600">Status</span>
                <span className="font-medium capitalize">{order.status.replace('_', ' ')}</span>
              </div>
              <div className="border-t pt-3">
                <div className="flex justify-between">
                  <span className="text-gray-600">Total Amount</span>
                  <span className="font-semibold text-lg">{formatCurrency(order.total_amount)}</span>
                </div>
              </div>
            </div>
          </div>

          {/* Need Help */}
          <div className="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6">
            <h3 className="text-lg font-semibold text-gray-900 mb-2">Need Help?</h3>
            <p className="text-gray-600 text-sm mb-4">
              Our support team is here to assist you with any questions about your order.
            </p>
            <div className="space-y-2 text-sm">
              <div className="flex items-center text-gray-600">
                <PhoneIcon className="w-4 h-4 mr-2" />
                <span>+234 800 DHR SPACE</span>
              </div>
              <div className="flex items-center text-gray-600">
                <ChatBubbleLeftRightIcon className="w-4 h-4 mr-2" />
                <span>support@dhrspace.ng</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
} 