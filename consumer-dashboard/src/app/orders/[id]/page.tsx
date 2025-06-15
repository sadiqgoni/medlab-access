import { Suspense } from 'react';
import OrderDetailsClient from './OrderDetailsClient';

// Generate static paths for the dynamic route
export async function generateStaticParams() {
  // For static export, we need to provide possible order IDs
  // Using the same mock order IDs from the store
  const mockOrderIds = ['1', '2', '3', '4'];
  
  return mockOrderIds.map((id) => ({
    id: id,
  }));
}

export default async function OrderDetailsPage({ params }: { params: Promise<{ id: string }> }) {
  const { id } = await params;
  
  return (
    <Suspense fallback={
      <div className="flex items-center justify-center min-h-96">
        <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
      </div>
    }>
      <OrderDetailsClient orderId={id} />
    </Suspense>
  );
} 