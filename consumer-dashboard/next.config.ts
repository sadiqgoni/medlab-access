import type { NextConfig } from "next";

const nextConfig: NextConfig = {
  output: 'export',
  images: {
    domains: ['dhealthrides.com', 'localhost'],
    unoptimized: true
  },
  trailingSlash: true,
  eslint: {
    ignoreDuringBuilds: true,
  },
  typescript: {
    ignoreBuildErrors: true,
  },
  env: {
    NEXT_PUBLIC_API_URL: process.env.NODE_ENV === 'production' 
      ? 'https://dhealthrides.com/api' 
      : 'http://localhost:3000/api'
  }
};

export default nextConfig;
