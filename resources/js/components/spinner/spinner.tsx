import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";

type SpinnerProps = Omit<React.ComponentProps<typeof Icon>, "name"> & {};

function Spinner({ className, ...props }: SpinnerProps) {
  return (
    <Icon
      data-slot="spinner"
      className={cn("animate-spin", className)}
      name="loader-circle"
      {...props}
    />
  );
}

export default Spinner;
