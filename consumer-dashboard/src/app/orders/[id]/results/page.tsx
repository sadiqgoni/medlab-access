import { Suspense } from 'react';
import ResultsClient from './ResultsClient';

// Generate static paths for the dynamic route
export async function generateStaticParams() {
  // For static export, we need to provide possible order IDs
  const mockOrderIds = ['1', '2', '3', '4'];
  
  return mockOrderIds.map((id) => ({
    id: id,
  }));
}

export default async function ResultsPage({ params }: { params: Promise<{ id: string }> }) {
  const { id } = await params;
  
  return (
    <Suspense fallback={
      <div className="flex items-center justify-center min-h-96">
        <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
      </div>
    }>
      <ResultsClient orderId={id} />
    </Suspense>
  );
} 