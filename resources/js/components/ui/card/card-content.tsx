import { cn } from "@/lib/utils";

export type CardContentProps = React.ComponentProps<"div"> & {};

function CardContent({ className, ...props }: CardContentProps) {
  return (
    <div
      data-slot="card-description"
      className={cn("px-6", className)}
      {...props}
    />
  );
}

export default CardContent;
