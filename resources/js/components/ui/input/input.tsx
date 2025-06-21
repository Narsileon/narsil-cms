import { cn } from "@/lib/utils";

export type InputProps = React.ComponentProps<"input"> & {};

function Input({ className, type, ...props }: InputProps) {
  return (
    <input
      data-slot="input"
      className={cn(
        "border-input flex h-9 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs transition-[color,box-shadow] outline-none",
        "aria-invalid:ring-destructive/20 aria-invalid:border-destructive",
        "dark:aria-invalid:ring-destructive/40",
        "dark:bg-input/30",
        "disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm",
        "file:text-foreground file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium",
        "focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]",
        "placeholder:text-muted-foreground",
        "selection:bg-primary selection:text-primary-foreground",
        className,
      )}
      type={type}
      {...props}
    />
  );
}

export default Input;
