import { cn } from "@/components";

export type CardContentProps = React.ComponentProps<"div"> & {};

function CardContent({ className, ...props }: CardContentProps) {
  return (
    <div
      className={cn("px-6", className)}
      data-slot="card-description"
      {...props}
    />
  );
}

export default CardContent;
