import { cn } from "@narsil-cms/lib/utils";
import { Loader2 } from "lucide-react";

type SpinnerProps = React.ComponentProps<typeof Loader2> & {};

function Spinner({ className, ...props }: SpinnerProps) {
  return (
    <Loader2
      data-slot="spinner"
      className={cn("size-6 animate-spin", className)}
      {...props}
    />
  );
}

export default Spinner;
