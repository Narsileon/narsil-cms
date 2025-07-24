import { cn } from "@narsil-cms/lib/utils";

type TextareaProps = React.ComponentProps<"textarea"> & {};

function Textarea({ className, ...props }: TextareaProps) {
  return (
    <textarea
      data-slot="textarea"
      className={cn(
        "border-input placeholder:text-muted-foreground flex field-sizing-content min-h-16 w-full rounded-md border bg-transparent px-3 py-2 text-base shadow-xs transition-[color,box-shadow] outline-none",
        "aria-invalid:ring-destructive/20 aria-invalid:border-destructive",
        "dark:aria-invalid:ring-destructive/40 dark:bg-input/30",
        "disabled:cursor-not-allowed disabled:opacity-50 md:text-sm",
        "focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]",
        className,
      )}
      {...props}
    />
  );
}

export default Textarea;
