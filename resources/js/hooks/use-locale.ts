import { usePage } from "@inertiajs/react";
import type { GlobalProps } from "@/types/global";

export function useLocale() {
  const { locale = "en" } = usePage<GlobalProps>().props.shared;

  return locale;
}

export default useLocale;
