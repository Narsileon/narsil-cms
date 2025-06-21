import { cn } from "@/lib/utils";

export type CardFooterProps = React.ComponentProps<"div"> & {};

function CardFooter({ className, ...props }: CardFooterProps) {
  return (
    <div
      className={cn("flex items-center px-6 [.border-t]:pt-6", className)}
      data-slot="card-footer"
      {...props}
    />
  );
}

export default CardFooter;
