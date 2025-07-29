import { cn } from "@narsil-cms/lib/utils";

type CardContentProps = React.ComponentProps<"div"> & {};

function CardContent({ className, ...props }: CardContentProps) {
  return (
    <div
      data-slot="card-content"
      className={cn("grid gap-y-6 p-6", className)}
      {...props}
    />
  );
}

export default CardContent;
