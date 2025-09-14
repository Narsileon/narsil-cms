import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";

type SpinnerRootProps = Omit<React.ComponentProps<typeof Icon>, "name"> & {};

function SpinnerRoot({ className, ...props }: SpinnerRootProps) {
  return (
    <Icon
      data-slot="spinner-root"
      className={cn("animate-spin", className)}
      name="loader-circle"
      {...props}
    />
  );
}

export default SpinnerRoot;
