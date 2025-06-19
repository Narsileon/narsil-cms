import { cn } from "@/Components";
import { Loader2, LucideProps } from "lucide-react";

export type SpinnerProps = LucideProps & {};

function Spinner({ className, ...props }: SpinnerProps) {
  return (
    <Loader2 className={cn("size-6 animate-spin", className)} {...props} />
  );
}

export default Spinner;
