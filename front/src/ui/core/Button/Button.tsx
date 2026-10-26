import { type PropsWithChildren, type ButtonHTMLAttributes } from "react";

interface Props extends ButtonHTMLAttributes<HTMLButtonElement> {}

export default function Button({
  children,
  disabled = false,
  ...props
}: PropsWithChildren<Props>) {
  return (
    <button
      className="flex items-center gap-1 px-3 py-1 border border-gray-200 rounded text-xs hover:bg-gray-200 hover:cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed"
      disabled={disabled}
      {...props}
    >
      {children}
    </button>
  );
}
