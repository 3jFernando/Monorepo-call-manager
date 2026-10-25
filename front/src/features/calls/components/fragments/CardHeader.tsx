import React from 'react'
import { JSX } from 'react/jsx-runtime'

interface Props {
    title: string
    icon: JSX.Element,
    value: string,
    period: string
}

export default function CardHeader({ title, icon, value, period }: Props) {
    return (
        <div className="rounded-md border border-gray-100 shadow p-4 bg-white">
            <div className="flex items-center justify-between">
                <p className="text-xs font-bold">{title}</p>
                {icon}
            </div>
            <div className="mt-2">
                <p className="text-2xl font-bold">{value}</p>
                <p className="text-xs text-muted-foreground">{period}</p>
            </div>
        </div>
    )
}