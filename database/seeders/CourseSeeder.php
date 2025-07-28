<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Forex Trading Course
        $forexCourse = Course::firstOrCreate(
            ['slug' => 'forex-trading-mastery'],
            [
                'title' => 'Forex Trading Mastery',
                'price' => 299.00,
                'description' => 'Learn the fundamentals of Forex trading, technical analysis, and risk management. This comprehensive course covers everything from basic concepts to advanced strategies.',
                'image' => null,
                'is_published' => true,
            ]
        );

        // Create lessons for Forex course
        $forexLessons = [
            [
                'title' => 'Introduction to Forex Trading',
                'description' => 'Understanding the basics of currency trading and market structure.',
                'video_url' => 'https://example.com/video1.mp4',
                'video_duration' => '15:30',
                'order' => 1,
                'is_free' => true,
            ],
            [
                'title' => 'Technical Analysis Fundamentals',
                'description' => 'Learn to read charts and identify key support and resistance levels.',
                'video_url' => 'https://example.com/video2.mp4',
                'video_duration' => '22:15',
                'order' => 2,
                'is_free' => false,
            ],
            [
                'title' => 'Risk Management Strategies',
                'description' => 'Essential risk management techniques to protect your capital.',
                'video_url' => 'https://example.com/video3.mp4',
                'video_duration' => '18:45',
                'order' => 3,
                'is_free' => false,
            ],
            [
                'title' => 'Advanced Trading Strategies',
                'description' => 'Master advanced trading techniques and strategies.',
                'video_url' => 'https://example.com/video4.mp4',
                'video_duration' => '25:20',
                'order' => 4,
                'is_free' => false,
            ],
        ];

        foreach ($forexLessons as $lesson) {
            $forexCourse->lessons()->firstOrCreate(
                ['title' => $lesson['title']],
                $lesson
            );
        }

        // Create Volatility Trading Course
        $volatilityCourse = Course::firstOrCreate(
            ['slug' => 'volatility-trading-strategies'],
            [
                'title' => 'Volatility Trading Strategies',
                'price' => 199.00,
                'description' => 'Master the art of trading volatility. Learn how to profit from market volatility using options and other derivative instruments.',
                'image' => null,
                'is_published' => true,
            ]
        );

        // Create lessons for Volatility course
        $volatilityLessons = [
            [
                'title' => 'Understanding Volatility',
                'description' => 'What is volatility and how to measure it in financial markets.',
                'video_url' => 'https://example.com/video5.mp4',
                'video_duration' => '12:30',
                'order' => 1,
                'is_free' => true,
            ],
            [
                'title' => 'Options Trading Basics',
                'description' => 'Introduction to options trading and basic strategies.',
                'video_url' => 'https://example.com/video6.mp4',
                'video_duration' => '20:15',
                'order' => 2,
                'is_free' => false,
            ],
            [
                'title' => 'Volatility Trading Strategies',
                'description' => 'Advanced strategies for trading volatility.',
                'video_url' => 'https://example.com/video7.mp4',
                'video_duration' => '28:45',
                'order' => 3,
                'is_free' => false,
            ],
        ];

        foreach ($volatilityLessons as $lesson) {
            $volatilityCourse->lessons()->firstOrCreate(
                ['title' => $lesson['title']],
                $lesson
            );
        }

        // Create Advanced Trading Course
        $advancedCourse = Course::firstOrCreate(
            ['slug' => 'advanced-trading-techniques'],
            [
                'title' => 'Advanced Trading Techniques',
                'price' => 399.00,
                'description' => 'Take your trading to the next level with advanced techniques, algorithmic trading, and portfolio management.',
                'image' => null,
                'is_published' => true,
            ]
        );

        // Create lessons for Advanced course
        $advancedLessons = [
            [
                'title' => 'Algorithmic Trading Introduction',
                'description' => 'Introduction to algorithmic trading and automated strategies.',
                'video_url' => 'https://example.com/video8.mp4',
                'video_duration' => '16:20',
                'order' => 1,
                'is_free' => true,
            ],
            [
                'title' => 'Portfolio Management',
                'description' => 'Learn to manage a trading portfolio effectively.',
                'video_url' => 'https://example.com/video9.mp4',
                'video_duration' => '24:30',
                'order' => 2,
                'is_free' => false,
            ],
            [
                'title' => 'Advanced Risk Management',
                'description' => 'Sophisticated risk management techniques for professional traders.',
                'video_url' => 'https://example.com/video10.mp4',
                'video_duration' => '19:15',
                'order' => 3,
                'is_free' => false,
            ],
        ];

        foreach ($advancedLessons as $lesson) {
            $advancedCourse->lessons()->firstOrCreate(
                ['title' => $lesson['title']],
                $lesson
            );
        }
    }
}
