import { isEmpty } from "lodash";
import { usePage } from "@inertiajs/react";
import type { GlobalProps } from "@/types/global";

export function useAuth() {
  const { auth } = usePage<GlobalProps>().props;

  return isEmpty(auth) ? null : auth;
}

export default useAuth;
