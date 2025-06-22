import { cn } from "@/lib/utils";

export type CardFooterProps = React.ComponentProps<"div"> & {};

function CardFooter({ className, ...props }: CardFooterProps) {
  return (
    <div
      data-slot="card-footer"
      className={cn("flex items-center px-4 [.border-t]:pt-4", className)}
      {...props}
    />
  );
}

export default CardFooter;
