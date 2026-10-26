import { type PropsWithChildren, type ButtonHTMLAttributes } from "react";

interface Props extends ButtonHTMLAttributes<HTMLButtonElement> {}

export default function ButtonSpam({
  children,
  disabled = false,
  ...props
}: PropsWithChildren<Props>) {
  return (
    <button
      className="flex items-center text-xs border border-gray-200 disabled:border-red-300 hover:bg-red-100 disabled:bg-red-100 hover:cursor-pointer disabled:cursor-not-allowed transition-all text-gray-700 disabled:text-red-800 px-2 py-1 rounded-md"
      disabled={disabled}
      {...props}
    >
      {children}
    </button>
  );
}
